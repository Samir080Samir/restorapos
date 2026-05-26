<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use Illuminate\Support\Facades\Session;

class QrLiveMonitorController extends Controller
{
    public function index()
    {
        if (! Session::has('owner_restaurant_id')) {
            return redirect()->route('owner.login');
        }

        return view('owner.qr-live.index');
    }

    public function data()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        $orders = PosOrder::with(['table', 'items'])
            ->where('restaurant_id', $restaurantId)
            ->where('status', 'open')
            ->latest('opened_at')
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'table' => optional($order->table)->name ?? 'Masa',
                    'total' => number_format((float) $order->total_amount, 2),
                    'note' => $order->note,
                    'items' => $order->items->map(fn($item) => [
                        'name' => $item->product_name,
                        'qty' => $item->qty,
                        'total' => number_format((float) $item->total_price, 2),
                    ]),
                ];
            }),
        ]);
    }
}
