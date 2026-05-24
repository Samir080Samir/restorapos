<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosOrderController extends Controller
{
    public function active(Request $request, RestaurantTable $table)
    {
        $staffId = session('staff_user_id');

        $order = PosOrder::with(['items', 'staff'])
            ->where('table_id', $table->id)
            ->where('status', 'open')
            ->latest()
            ->first();

        if (! $order) {
            return response()->json([
                'success' => true,
                'has_order' => false,
                'items' => [],
            ]);
        }

        if ($order->staff_id && (int) $order->staff_id !== (int) $staffId) {
            return response()->json([
                'success' => false,
                'locked' => true,
                'message' => 'Bu masa ' . optional($order->staff)->name . ' tərəfindən idarə olunur.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'has_order' => true,
            'order_id' => $order->id,
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'product_id' => $item->product_id,
                    'name' => $item->product_name,
                    'price' => (float) $item->price,
                    'qty' => (float) $item->qty,
                ];
            })->values(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
            'items' => ['nullable', 'array'],
        ]);

        $items = $request->input('items', []);
        $staffId = session('staff_user_id');

        if (empty($items)) {

            $table = RestaurantTable::findOrFail($request->table_id);

            $order = PosOrder::where('table_id', $table->id)
                ->where('status', 'open')
                ->latest()
                ->first();

            if ($order) {
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

            $table->update([
                'status' => 'empty',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Masa boşaldıldı.',
                'table_status' => 'empty',
            ]);
        }

        DB::beginTransaction();

        try {
            $table = RestaurantTable::findOrFail($request->table_id);

            $order = PosOrder::where('table_id', $table->id)
                ->where('status', 'open')
                ->latest()
                ->first();

            if ($order && $order->staff_id && (int) $order->staff_id !== (int) $staffId) {
                return response()->json([
                    'success' => false,
                    'locked' => true,
                    'message' => 'Bu masa ' . optional($order->staff)->name . ' tərəfindən idarə olunur.',
                ], 403);
            }

            $subtotal = 0;

            foreach ($items as $item) {
                $subtotal += (float) ($item['price'] ?? 0) * (float) ($item['qty'] ?? 1);
            }

            if (! $order) {
                $order = PosOrder::create([
                    'restaurant_id' => $table->restaurant_id,
                    'branch_id' => $table->branch_id,
                    'table_id' => $table->id,
                    'staff_id' => $staffId,
                    'order_number' => 'POS-' . strtoupper(Str::random(8)),
                    'status' => 'open',
                    'opened_at' => now(),
                ]);
            }

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

            $order->update([
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'total_amount' => $subtotal,
            ]);

            $table->update([
                'status' => 'busy',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sifariş saxlanıldı.',
                'order_id' => $order->id,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
