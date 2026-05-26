<?php

namespace App\Http\Controllers\QrMenu;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\PosOrder;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Models\PosOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QrMenuController extends Controller
{
    public function showRestaurant(Request $request, string $restaurantSlug)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        $this->trackQrView($request, $restaurant, null, 'menu');

        if (! $restaurant->hasActiveLicense()) {
            return view('public.qr-menu.disabled', [
                'restaurant' => $restaurant,
                'table' => null,
                'message' => 'QR Menu hazırda aktiv deyil.',
            ]);
        }

        $categories = MenuCategory::query()
            ->where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->whereHas('products', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('is_active', true)
                    ->where('is_hidden', false)
                    ->where('show_in_qr_menu', true);
            })
            ->with(['products' => function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('is_active', true)
                    ->where('is_hidden', false)
                    ->where('show_in_qr_menu', true)
                    ->orderBy('sort_order')
                    ->orderBy('name');
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $uncategorizedProducts = Product::query()
            ->where('restaurant_id', $restaurant->id)
            ->whereNull('menu_category_id')
            ->where('is_active', true)
            ->where('is_hidden', false)
            ->where('show_in_qr_menu', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $table = null;
        $openOrders = collect();
        $currentBillTotal = 0;

        return view('public.qr-menu.show', compact(
            'restaurant',
            'table',
            'categories',
            'uncategorizedProducts',
            'openOrders',
            'currentBillTotal'
        ));
    }

    public function show(Request $request, string $restaurantSlug, string $tableCode)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        $table = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->where('code', $tableCode)
            ->firstOrFail();

        $this->trackQrView($request, $restaurant, $table, 'table');

        if (! $restaurant->hasActiveLicense()) {
            return view('public.qr-menu.disabled', [
                'restaurant' => $restaurant,
                'table' => $table,
                'message' => 'QR Menu hazırda aktiv deyil.',
            ]);
        }

        $categories = MenuCategory::query()
            ->where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->whereHas('products', function ($query) use ($restaurant, $table) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('is_active', true)
                    ->where('is_hidden', false)
                    ->where('show_in_qr_menu', true)
                    ->when($table->branch_id, function ($sub) use ($table) {
                        $sub->where(function ($branchQuery) use ($table) {
                            $branchQuery->whereNull('branch_id')
                                ->orWhere('branch_id', $table->branch_id);
                        });
                    });
            })
            ->with(['products' => function ($query) use ($restaurant, $table) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('is_active', true)
                    ->where('is_hidden', false)
                    ->where('show_in_qr_menu', true)
                    ->when($table->branch_id, function ($sub) use ($table) {
                        $sub->where(function ($branchQuery) use ($table) {
                            $branchQuery->whereNull('branch_id')
                                ->orWhere('branch_id', $table->branch_id);
                        });
                    })
                    ->orderBy('sort_order')
                    ->orderBy('name');
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $uncategorizedProducts = Product::query()
            ->where('restaurant_id', $restaurant->id)
            ->whereNull('menu_category_id')
            ->where('is_active', true)
            ->where('is_hidden', false)
            ->where('show_in_qr_menu', true)
            ->when($table->branch_id, function ($query) use ($table) {
                $query->where(function ($branchQuery) use ($table) {
                    $branchQuery->whereNull('branch_id')
                        ->orWhere('branch_id', $table->branch_id);
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $openOrders = PosOrder::query()
            ->with(['items'])
            ->where('restaurant_id', $restaurant->id)
            ->where('table_id', $table->id)
            ->where('status', 'open')
            ->orderBy('opened_at')
            ->get();

        $currentBillTotal = (float) $openOrders->sum('total_amount');

        if ($currentBillTotal <= 0) {
            $currentBillTotal = (float) $openOrders->sum(function ($order) {
                return $order->items->sum('total_price');
            });
        }

        return view('public.qr-menu.show', compact(
            'restaurant',
            'table',
            'categories',
            'uncategorizedProducts',
            'openOrders',
            'currentBillTotal'
        ));
    }

    public function sendOrder(Request $request, string $restaurantSlug, string $tableCode)
    {
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.product_id' => ['nullable', 'integer'],
            'items.*.name' => ['nullable', 'string', 'max:255'],
            'items.*.price' => ['nullable', 'numeric', 'min:0'],
            'items.*.qty' => ['required', 'numeric', 'min:0.01'],
            'items.*.note' => ['nullable', 'string', 'max:1000'],
        ]);

        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        if (! $restaurant->hasActiveLicense()) {
            return response()->json([
                'success' => false,
                'message' => 'QR Menu hazırda aktiv deyil.',
            ], 403);
        }

        $table = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->where('code', $tableCode)
            ->lockForUpdate()
            ->firstOrFail();

        try {
            $result = DB::transaction(function () use ($request, $restaurant, $table) {
                $table->refresh();

                if ($table->status === 'waiting_payment') {
                    throw new \RuntimeException('Bu masa üçün hesab istənilib. Əlavə sifariş üçün ofisianta müraciət edin.');
                }

                $order = PosOrder::create([
                    'restaurant_id' => $restaurant->id,
                    'branch_id' => $table->branch_id,
                    'table_id' => $table->id,
                    'staff_id' => null,
                    'order_number' => $this->makeQrOrderNumber(),
                    'status' => 'open',
                    'opened_at' => now(),
                    'subtotal' => 0,
                    'discount_amount' => 0,
                    'tax_amount' => 0,
                    'total_amount' => 0,
                    'note' => 'QR Menu sifarişi',
                ]);

                $subtotal = 0;

                foreach ($request->input('items', []) as $item) {
                    $productId = $item['product_id'] ?? $item['id'] ?? null;
                    $product = null;

                    if ($productId) {
                        $product = Product::query()
                            ->where('restaurant_id', $restaurant->id)
                            ->where('id', $productId)
                            ->where('is_active', true)
                            ->where('is_hidden', false)
                            ->where('show_in_qr_menu', true)
                            ->when($table->branch_id, function ($query) use ($table) {
                                $query->where(function ($branchQuery) use ($table) {
                                    $branchQuery->whereNull('branch_id')
                                        ->orWhere('branch_id', $table->branch_id);
                                });
                            })
                            ->first();
                    }

                    $qty = max(0.01, (float) ($item['qty'] ?? 1));
                    $price = $product ? (float) $product->sale_price : (float) ($item['price'] ?? 0);
                    $name = $product ? $product->name : trim((string) ($item['name'] ?? 'Məhsul'));
                    $lineTotal = round($qty * $price, 2);

                    PosOrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product?->id ?? $productId,
                        'product_name' => $name,
                        'qty' => $qty,
                        'price' => $price,
                        'total_price' => $lineTotal,
                        'note' => $item['note'] ?? null,
                    ]);

                    $subtotal += $lineTotal;
                }

                $order->update([
                    'subtotal' => round($subtotal, 2),
                    'discount_amount' => 0,
                    'tax_amount' => 0,
                    'total_amount' => round($subtotal, 2),
                ]);

                $table->update(['status' => 'busy']);

                if (method_exists($table, 'refreshOperationalStatus')) {
                    $table->refreshOperationalStatus();
                }

                return [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => round($subtotal, 2),
                    'table_status' => $table->fresh()->status,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Sifariş göndərildi.',
                'order_id' => $result['order_id'],
                'order_number' => $result['order_number'],
                'total_amount' => $result['total_amount'],
                'table_status' => $result['table_status'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function requestBill(Request $request, string $restaurantSlug, string $tableCode)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        $table = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->where('code', $tableCode)
            ->lockForUpdate()
            ->firstOrFail();

        try {
            $result = DB::transaction(function () use ($table) {
                $table->refresh();

                $hasOpenOrder = PosOrder::where('table_id', $table->id)
                    ->where('status', 'open')
                    ->exists();

                if (! $hasOpenOrder) {
                    throw new \RuntimeException('Hesab istəmək üçün bu masada açıq sifariş yoxdur.');
                }

                $table->update(['status' => 'waiting_payment']);

                return ['table_status' => 'waiting_payment'];
            });

            return response()->json([
                'success' => true,
                'message' => 'Hesab istəyi göndərildi.',
                'table_status' => $result['table_status'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    private function trackQrView(Request $request, Restaurant $restaurant, ?RestaurantTable $table, string $type): void
    {
        try {
            DB::table('qr_menu_views')->insert([
                'restaurant_id' => $restaurant->id,
                'branch_id' => $table?->branch_id,
                'table_id' => $table?->id,
                'type' => $type,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Baxış statistikası menyunun açılmasına mane olmamalıdır.
        }
    }

    private function makeQrOrderNumber(): string
    {
        return 'QR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
