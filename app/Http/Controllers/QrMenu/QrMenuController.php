<?php

namespace App\Http\Controllers\QrMenu;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\PosOrder;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\RestaurantTable;

class QrMenuController extends Controller
{
    public function showRestaurant(string $restaurantSlug)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

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

    public function show(string $restaurantSlug, string $tableCode)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        $table = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->where('code', $tableCode)
            ->firstOrFail();

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
}
