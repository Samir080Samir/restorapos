<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\PosPayment;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosOrderController extends Controller
{
    public function active(Request $request, RestaurantTable $table)
    {
        $staffId = session('staff_user_id');
        $staffRole = session('staff_user_role');

        $orders = PosOrder::with(['items', 'staff'])
            ->where('table_id', $table->id)
            ->where('status', 'open')
            ->oldest()
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => true,
                'has_order' => false,
                'order_id' => null,
                'checks' => [],
                'items' => [],
                'table_status' => $table->status ?: 'empty',
                'payment_locked' => ($table->status === 'waiting_payment'),
            ]);
        }

        $lockedOrder = $orders->first(function ($order) use ($staffId, $staffRole) {
            return $staffRole !== 'cashier'
                && $order->staff_id
                && (int) $order->staff_id !== (int) $staffId;
        });

        if ($lockedOrder) {
            return response()->json([
                'success' => false,
                'locked' => true,
                'message' => 'Bu masa ' . optional($lockedOrder->staff)->name . ' tərəfindən idarə olunur.',
            ], 403);
        }

        $currentOrderId = $request->integer('order_id') ?: optional($orders->last())->id;
        $currentOrder = $orders->firstWhere('id', $currentOrderId) ?: $orders->last();

        return response()->json([
            'success' => true,
            'has_order' => true,
            'order_id' => $currentOrder?->id,
            'table_status' => $table->status ?: 'empty',
            'payment_locked' => ($table->status === 'waiting_payment'),
            'staff_name' => optional($currentOrder?->staff)->name ?: session('staff_user_name'),
            'opened_at' => optional($currentOrder?->opened_at)->toIso8601String(),
            'checks' => $orders->map(function ($order, $index) {
                return [
                    'id' => $order->id,
                    'label' => 'Çek #' . $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => (float) $order->total_amount,
                    'items_count' => $order->items->count(),
                    'opened_at' => optional($order->opened_at)->toIso8601String(),
                ];
            })->values(),
            'items' => $currentOrder ? $this->formatItems($currentOrder) : [],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
            'order_id' => ['nullable', 'exists:pos_orders,id'],
            'items' => ['nullable', 'array'],
            'clear_table' => ['nullable', 'boolean'],
        ]);

        $items = $request->input('items', []);
        $staffId = session('staff_user_id');
        $staffRole = session('staff_user_role');

        DB::beginTransaction();

        try {
            $table = RestaurantTable::lockForUpdate()->findOrFail($request->table_id);

            if ($table->status === 'waiting_payment') {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'payment_locked' => true,
                    'message' => 'Bu masa üçün hesab yazılıb və masa kilidlidir. Əlavə sifariş üçün əvvəl “Kilidi aç” edin.',
                ], 423);
            }

            if ($request->boolean('clear_table')) {
                $this->cancelOpenOrdersForTable($table);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Masa boşaldıldı.',
                    'table_status' => 'empty',
                ]);
            }

            $order = $this->resolveOrderForSave($request, $table, $staffId, $staffRole);

            if ($staffRole !== 'cashier' && $order && $order->staff_id && (int) $order->staff_id !== (int) $staffId) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'locked' => true,
                    'message' => 'Bu masa ' . optional($order->staff)->name . ' tərəfindən idarə olunur.',
                ], 403);
            }

            if (empty($items)) {
                if ($order) {
                    $order->items()->delete();
                    $this->recalculateOrder($order->fresh('items'));
                }

                $this->syncTableStatus($table);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Sifariş saxlanıldı.',
                    'order_id' => $order?->id,
                    'opened_at' => optional($order?->opened_at)->toIso8601String(),
                    'staff_name' => session('staff_user_name'),
                    'table_status' => $table->fresh()->status,
                ]);
            }

            if (! $order) {
                $order = PosOrder::create([
                    'restaurant_id' => $table->restaurant_id,
                    'branch_id' => $table->branch_id,
                    'table_id' => $table->id,
                    'staff_id' => $staffId,
                    'order_number' => $this->makeOrderNumber(),
                    'status' => 'open',
                    'opened_at' => now(),
                    'subtotal' => 0,
                    'discount_amount' => 0,
                    'tax_amount' => 0,
                    'total_amount' => 0,
                ]);
            }

            $this->replaceOrderItems($order, $items);
            $this->recalculateOrder($order->fresh('items'));
            $this->syncTableStatus($table);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sifariş saxlanıldı.',
                'order_id' => $order->id,
                'opened_at' => optional($order->opened_at)->toIso8601String(),
                'staff_name' => session('staff_user_name'),
                'table_status' => 'busy',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function newCheck(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
        ]);

        $staffId = session('staff_user_id');
        $table = RestaurantTable::findOrFail($request->table_id);

        $order = PosOrder::create([
            'restaurant_id' => $table->restaurant_id,
            'branch_id' => $table->branch_id,
            'table_id' => $table->id,
            'staff_id' => $staffId,
            'order_number' => $this->makeOrderNumber(),
            'status' => 'open',
            'opened_at' => now(),
            'subtotal' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total_amount' => 0,
        ]);

        $table->update(['status' => 'busy']);

        return response()->json([
            'success' => true,
            'message' => 'Yeni çek açıldı.',
            'order_id' => $order->id,
            'opened_at' => optional($order->opened_at)->toIso8601String(),
            'staff_name' => session('staff_user_name'),
        ]);
    }

    public function moveTable(Request $request)
    {
        $request->validate([
            'from_table_id' => ['required', 'exists:restaurant_tables,id'],
            'to_table_id' => ['required', 'exists:restaurant_tables,id', 'different:from_table_id'],
        ]);

        try {
            $movedCount = 0;

            DB::transaction(function () use ($request, &$movedCount) {
                $fromTable = RestaurantTable::lockForUpdate()->findOrFail($request->from_table_id);
                $toTable = RestaurantTable::lockForUpdate()->findOrFail($request->to_table_id);

                $openOrders = PosOrder::where('table_id', $fromTable->id)
                    ->where('status', 'open')
                    ->lockForUpdate()
                    ->get();

                if ($openOrders->isEmpty()) {
                    throw new \RuntimeException('Bu masada açıq çek yoxdur. Əvvəl məhsul əlavə edib “Bağla” edin və ya sifarişi saxlayın.');
                }

                $targetHasOpenOrder = PosOrder::where('table_id', $toTable->id)
                    ->where('status', 'open')
                    ->exists();

                if ($targetHasOpenOrder) {
                    throw new \RuntimeException('Masanı dəyişmək üçün hədəf masa boş olmalıdır. Dolu masaya keçirmək üçün “Masanı birləşdir” istifadə edin.');
                }

                $movedCount = $openOrders->count();

                PosOrder::whereIn('id', $openOrders->pluck('id'))->update([
                    'table_id' => $toTable->id,
                    'branch_id' => $toTable->branch_id,
                ]);

                $this->syncTableStatus($fromTable);
                $this->syncTableStatus($toTable);
            });

            return response()->json([
                'success' => true,
                'message' => 'Masa dəyişdirildi.',
                'moved_count' => $movedCount,
                'to_table_id' => (int) $request->to_table_id,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function mergeTables(Request $request)
    {
        $request->validate([
            'from_table_id' => ['required', 'exists:restaurant_tables,id'],
            'to_table_id' => ['required', 'exists:restaurant_tables,id', 'different:from_table_id'],
        ]);

        try {
            $movedCount = 0;

            DB::transaction(function () use ($request, &$movedCount) {
                $fromTable = RestaurantTable::lockForUpdate()->findOrFail($request->from_table_id);
                $toTable = RestaurantTable::lockForUpdate()->findOrFail($request->to_table_id);

                $openOrders = PosOrder::where('table_id', $fromTable->id)
                    ->where('status', 'open')
                    ->lockForUpdate()
                    ->get();

                if ($openOrders->isEmpty()) {
                    throw new \RuntimeException('Birləşdiriləcək masada açıq çek yoxdur.');
                }

                $movedCount = $openOrders->count();

                PosOrder::whereIn('id', $openOrders->pluck('id'))->update([
                    'table_id' => $toTable->id,
                    'branch_id' => $toTable->branch_id,
                ]);

                $this->syncTableStatus($fromTable);
                $this->syncTableStatus($toTable);
            });

            return response()->json([
                'success' => true,
                'message' => 'Masalar birləşdirildi. Çeklər ayrı saxlanıldı.',
                'moved_count' => $movedCount,
                'to_table_id' => (int) $request->to_table_id,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function mergeChecks(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
            'target_order_id' => ['nullable', 'exists:pos_orders,id'],
        ]);

        $mainOrderId = null;

        try {
            DB::transaction(function () use ($request, &$mainOrderId) {
                $orders = PosOrder::with('items')
                    ->where('table_id', $request->table_id)
                    ->where('status', 'open')
                    ->oldest()
                    ->lockForUpdate()
                    ->get();

                if ($orders->count() < 2) {
                    throw new \RuntimeException('Birləşdirmək üçün ən azı iki açıq çek olmalıdır.');
                }

                $mainOrder = $request->target_order_id
                    ? $orders->firstWhere('id', (int) $request->target_order_id)
                    : $orders->first();

                if (! $mainOrder) {
                    $mainOrder = $orders->first();
                }

                $mainOrderId = $mainOrder->id;

                foreach ($orders as $order) {
                    if ((int) $order->id === (int) $mainOrder->id) {
                        continue;
                    }

                    foreach ($order->items as $item) {
                        $existingItem = PosOrderItem::where('order_id', $mainOrder->id)
                            ->where('product_id', $item->product_id)
                            ->where('price', $item->price)
                            ->where(function ($query) use ($item) {
                                if ($item->note) {
                                    $query->where('note', $item->note);
                                } else {
                                    $query->whereNull('note')->orWhere('note', '');
                                }
                            })
                            ->first();

                        if ($existingItem) {
                            $newQty = (float) $existingItem->qty + (float) $item->qty;

                            $existingItem->update([
                                'qty' => $newQty,
                                'total_price' => $newQty * (float) $existingItem->price,
                            ]);
                        } else {
                            PosOrderItem::create([
                                'order_id' => $mainOrder->id,
                                'product_id' => $item->product_id,
                                'product_name' => $item->product_name,
                                'qty' => $item->qty,
                                'price' => $item->price,
                                'total_price' => $item->total_price,
                                'note' => $item->note,
                            ]);
                        }
                    }

                    $order->items()->delete();
                    $order->update([
                        'status' => 'cancelled',
                        'closed_at' => now(),
                        'subtotal' => 0,
                        'discount_amount' => 0,
                        'tax_amount' => 0,
                        'total_amount' => 0,
                    ]);
                }

                $this->recalculateOrder($mainOrder->fresh('items'));
                $this->syncTableStatus(RestaurantTable::findOrFail($request->table_id));
            });

            return response()->json([
                'success' => true,
                'message' => 'Çeklər bir hesaba birləşdirildi.',
                'order_id' => $mainOrderId,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function printBill(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
            'order_id' => ['nullable', 'exists:pos_orders,id'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $table = RestaurantTable::lockForUpdate()->findOrFail($request->table_id);

                $hasOpenOrder = PosOrder::where('table_id', $table->id)
                    ->where('status', 'open')
                    ->exists();

                if (! $hasOpenOrder) {
                    throw new \RuntimeException('Hesab yazmaq üçün bu masada açıq çek yoxdur.');
                }

                $table->update(['status' => 'waiting_payment']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Hesab yazıldı. Masa hesab gözləyir statusuna keçirildi.',
                'table_status' => 'waiting_payment',
                'payment_locked' => true,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function unlockBill(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $table = RestaurantTable::lockForUpdate()->findOrFail($request->table_id);

                if ($table->status !== 'waiting_payment') {
                    throw new \RuntimeException('Bu masa kilidli deyil.');
                }

                $hasOpenOrder = PosOrder::where('table_id', $table->id)
                    ->where('status', 'open')
                    ->exists();

                $table->update(['status' => $hasOpenOrder ? 'busy' : 'empty']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Masa kilidi açıldı. Əlavə sifariş qəbul edilə bilər.',
                'table_status' => 'busy',
                'payment_locked' => false,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function completePayment(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
            'order_id' => ['required', 'exists:pos_orders,id'],
            'payment_method' => ['required', 'in:cash,card,mixed'],
            'discount_type' => ['nullable', 'in:none,percent,amount'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'cash_amount' => ['nullable', 'numeric', 'min:0'],
            'card_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            $result = DB::transaction(function () use ($request) {
                $table = RestaurantTable::lockForUpdate()->findOrFail($request->table_id);

                $order = PosOrder::with('items')
                    ->where('id', $request->order_id)
                    ->where('table_id', $table->id)
                    ->where('status', 'open')
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($order->items->isEmpty()) {
                    throw new \RuntimeException('Ödəniş üçün çekdə məhsul yoxdur.');
                }

                $subtotal = (float) $order->items->sum('total_price');
                $discountType = $request->input('discount_type', 'none') ?: 'none';
                $discountValue = (float) $request->input('discount_value', 0);

                if ($discountType === 'percent') {
                    $discountAmount = min($subtotal, $subtotal * $discountValue / 100);
                } elseif ($discountType === 'amount') {
                    $discountAmount = min($subtotal, $discountValue);
                } else {
                    $discountAmount = 0;
                    $discountValue = 0;
                }

                $payable = round(max(0, $subtotal - $discountAmount), 2);
                $cashAmount = round((float) $request->input('cash_amount', 0), 2);
                $cardAmount = round((float) $request->input('card_amount', 0), 2);

                if ($request->payment_method === 'cash') {
                    $cashAmount = $payable;
                    $cardAmount = 0;
                }

                if ($request->payment_method === 'card') {
                    $cashAmount = 0;
                    $cardAmount = $payable;
                }

                if (round($cashAmount + $cardAmount, 2) !== $payable) {
                    throw new \RuntimeException('Ödəniş məbləği yekun məbləğlə uyğun deyil.');
                }

                PosPayment::create([
                    'restaurant_id' => $order->restaurant_id,
                    'branch_id' => $order->branch_id,
                    'table_id' => $table->id,
                    'order_id' => $order->id,
                    'staff_id' => session('staff_user_id'),
                    'subtotal' => $subtotal,
                    'discount_type' => $discountType,
                    'discount_value' => $discountValue,
                    'discount_amount' => $discountAmount,
                    'payable_amount' => $payable,
                    'cash_amount' => $cashAmount,
                    'card_amount' => $cardAmount,
                    'payment_method' => $request->payment_method,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                $order->update([
                    'status' => 'paid',
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => 0,
                    'total_amount' => $payable,
                    'closed_at' => now(),
                ]);

                $hasOtherOpenOrders = PosOrder::where('table_id', $table->id)
                    ->where('status', 'open')
                    ->exists();

                if ($hasOtherOpenOrders) {
                    $table->update(['status' => 'busy']);
                } elseif (method_exists($table, 'refreshOperationalStatus')) {
                    $table->refreshOperationalStatus();
                } else {
                    $table->update(['status' => 'empty']);
                }

                return [
                    'order_id' => $order->id,
                    'table_status' => $table->fresh()->status,
                    'paid_amount' => $payable,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Ödəniş tamamlandı.',
                'order_id' => $result['order_id'],
                'table_status' => $result['table_status'],
                'paid_amount' => $result['paid_amount'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    public function openChecks(Request $request)
    {
        $staffId = session('staff_user_id');
        $staffRole = session('staff_user_role');

        $requestedStatus = $request->query('status', 'open');
        $allowedStatuses = ['open', 'paid', 'all'];
        $statusFilter = in_array($requestedStatus, $allowedStatuses, true) ? $requestedStatus : 'open';

        $ordersQuery = PosOrder::query()
            ->select([
                'id',
                'restaurant_id',
                'branch_id',
                'table_id',
                'staff_id',
                'order_number',
                'status',
                'subtotal',
                'discount_amount',
                'tax_amount',
                'total_amount',
                'opened_at',
                'closed_at',
            ])
            ->with([
                'table:id,name,dining_area_id,status',
                'table.diningArea:id,name',
                'staff:id,name',
            ])
            ->withCount('items');

        if ($statusFilter === 'open') {
            $ordersQuery->where('status', 'open');
        } elseif ($statusFilter === 'paid') {
            $ordersQuery->where('status', 'paid');
        } else {
            $ordersQuery->whereIn('status', ['open', 'paid']);
        }

        if ($staffRole !== 'cashier') {
            $ordersQuery->where('staff_id', $staffId);
        }

        $orders = $ordersQuery
            ->orderByRaw("CASE WHEN status = 'open' THEN 0 ELSE 1 END")
            ->orderByDesc('opened_at')
            ->limit(150)
            ->get();

        $totalAmount = (float) $orders->sum(function ($order) {
            return (float) $order->total_amount;
        });

        return response()->json([
            'success' => true,
            'role' => $staffRole,
            'filter' => $statusFilter,
            'count' => $orders->count(),
            'total_amount' => round($totalAmount, 2),
            'checks' => $orders->map(function ($order) {
                $statusLabel = match ($order->status) {
                    'paid' => 'Bağlı',
                    default => 'Açıq',
                };

                return [
                    'id' => $order->id,
                    'label' => 'Çek #' . $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'status_label' => $statusLabel,
                    'table_id' => $order->table_id,
                    'table_name' => optional($order->table)->name ?: 'Masa',
                    'area_name' => optional(optional($order->table)->diningArea)->name ?: '',
                    'staff_name' => optional($order->staff)->name ?: 'Əməkdaş',
                    'items_count' => (int) ($order->items_count ?? 0),
                    'total_amount' => (float) $order->total_amount,
                    'opened_at' => optional($order->opened_at)->format('H:i'),
                    'closed_at' => optional($order->closed_at)->format('H:i'),
                    'opened_at_iso' => optional($order->opened_at)->toIso8601String(),
                    'closed_at_iso' => optional($order->closed_at)->toIso8601String(),
                    'table_status' => optional($order->table)->status ?: 'busy',
                ];
            })->values(),
        ]);
    }

    private function resolveOrderForSave(Request $request, RestaurantTable $table, ?int $staffId, ?string $staffRole = null): ?PosOrder
    {
        if ($request->filled('order_id')) {
            return PosOrder::where('id', $request->order_id)
                ->where('table_id', $table->id)
                ->where('status', 'open')
                ->first();
        }

        $query = PosOrder::where('table_id', $table->id)
            ->where('status', 'open');

        if ($staffRole !== 'cashier') {
            $query->where(function ($q) use ($staffId) {
                $q->whereNull('staff_id')
                    ->orWhere('staff_id', $staffId);
            });
        }

        return $query->latest()->first();
    }

    private function replaceOrderItems(PosOrder $order, array $items): void
    {
        $order->items()->delete();

        foreach ($items as $item) {
            $qty = (float) ($item['qty'] ?? 1);
            $price = (float) ($item['price'] ?? 0);

            PosOrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'] ?? $item['id'] ?? null,
                'product_name' => $item['name'] ?? 'Məhsul',
                'qty' => $qty,
                'price' => $price,
                'total_price' => $qty * $price,
                'note' => $item['note'] ?? null,
            ]);
        }
    }

    private function recalculateOrder(PosOrder $order): void
    {
        $subtotal = (float) $order->items()->sum('total_price');

        $order->update([
            'subtotal' => $subtotal,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total_amount' => $subtotal,
        ]);
    }

    private function cancelOpenOrdersForTable(RestaurantTable $table): void
    {
        $orders = PosOrder::where('table_id', $table->id)
            ->where('status', 'open')
            ->lockForUpdate()
            ->get();

        foreach ($orders as $order) {
            $order->items()->delete();
            $order->update([
                'status' => 'cancelled',
                'subtotal' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'total_amount' => 0,
                'closed_at' => now(),
            ]);
        }

        $table->update(['status' => 'empty']);
    }

    private function syncTableStatus(RestaurantTable $table): void
    {
        $table->refresh()->refreshOperationalStatus();
    }

    private function formatItems(PosOrder $order)
    {
        return $order->items
            ->groupBy(function ($item) {
                return implode('|', [
                    $item->product_id,
                    (string) $item->price,
                    (string) ($item->note ?? ''),
                ]);
            })
            ->map(function ($items) {
                $first = $items->first();
                $qty = (float) $items->sum('qty');
                $price = (float) $first->price;

                return [
                    'id' => $first->product_id,
                    'product_id' => $first->product_id,
                    'name' => $first->product_name,
                    'price' => $price,
                    'qty' => $qty,
                    'locked_qty' => $qty,
                    'note' => $first->note,
                ];
            })->values();
    }

    private function makeOrderNumber(): string
    {
        return 'POS-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
