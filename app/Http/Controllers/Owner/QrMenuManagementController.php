<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class QrMenuManagementController extends Controller
{
    public function index()
    {
        $restaurant = $this->restaurant();

        if (! $restaurant) {
            return redirect()->route('owner.login');
        }

        $branchId = $this->branchId();

        $tables = RestaurantTable::with('diningArea')
            ->where('restaurant_id', $restaurant->id)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereNull('branch_id')
                        ->orWhere('branch_id', $branchId);
                });
            })
            ->orderBy('dining_area_id')
            ->orderBy('name')
            ->get();

        $qrOrders = PosOrder::query()
            ->where('restaurant_id', $restaurant->id)
            ->where('order_number', 'like', 'QR-%');

        $todayQrOrdersQuery = PosOrder::query()
            ->where('restaurant_id', $restaurant->id)
            ->where('order_number', 'like', 'QR-%')
            ->whereDate('opened_at', today());

        $totalQrOrders = (clone $qrOrders)->count();
        $todayQrOrders = (clone $todayQrOrdersQuery)->count();
        $totalQrAmount = (float) (clone $qrOrders)->sum('total_amount');
        $todayQrAmount = (float) (clone $todayQrOrdersQuery)->sum('total_amount');
        $qrRevenue = $totalQrAmount;

        $activeQrTables = PosOrder::where('restaurant_id', $restaurant->id)
            ->where('status', 'open')
            ->where('order_number', 'like', 'QR-%')
            ->whereNotNull('table_id')
            ->distinct('table_id')
            ->count('table_id');

        $openQrOrders = PosOrder::where('restaurant_id', $restaurant->id)
            ->where('status', 'open')
            ->where('order_number', 'like', 'QR-%')
            ->count();

        $totalQrViews = DB::table('qr_menu_views')
            ->where('restaurant_id', $restaurant->id)
            ->count();

        $todayQrViews = DB::table('qr_menu_views')
            ->where('restaurant_id', $restaurant->id)
            ->whereDate('created_at', today())
            ->count();

        $tableViews = DB::table('qr_menu_views')
            ->select('table_id', DB::raw('COUNT(*) as views_count'))
            ->where('restaurant_id', $restaurant->id)
            ->whereNotNull('table_id')
            ->groupBy('table_id')
            ->pluck('views_count', 'table_id');

        $todayTableViews = DB::table('qr_menu_views')
            ->select('table_id', DB::raw('COUNT(*) as views_count'))
            ->where('restaurant_id', $restaurant->id)
            ->whereNotNull('table_id')
            ->whereDate('created_at', today())
            ->groupBy('table_id')
            ->pluck('views_count', 'table_id');

        $mostViewedTableRow = DB::table('qr_menu_views')
            ->select('table_id', DB::raw('COUNT(*) as views_count'))
            ->where('restaurant_id', $restaurant->id)
            ->whereNotNull('table_id')
            ->groupBy('table_id')
            ->orderByDesc('views_count')
            ->first();

        $mostViewedTable = null;

        if ($mostViewedTableRow) {
            $mostViewedTable = RestaurantTable::where('restaurant_id', $restaurant->id)
                ->where('id', $mostViewedTableRow->table_id)
                ->first();
        }

        $stats = [
            'total_orders' => $totalQrOrders,
            'today_orders' => $todayQrOrders,
            'total_amount' => $totalQrAmount,
            'today_amount' => $todayQrAmount,
            'active_tables' => $activeQrTables,
            'open_orders' => $openQrOrders,
            'total_views' => $totalQrViews,
            'today_views' => $todayQrViews,
            'most_viewed_table_name' => $mostViewedTable?->name,
            'most_viewed_table_count' => (int) ($mostViewedTableRow->views_count ?? 0),
        ];

        $topProducts = PosOrderItem::query()
            ->selectRaw('product_name, SUM(qty) as qty_sum, SUM(total_price) as total_sum')
            ->whereHas('order', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('order_number', 'like', 'QR-%');
            })
            ->groupBy('product_name')
            ->orderByDesc('qty_sum')
            ->limit(8)
            ->get();

        $restaurantQrUrl = route('public.qr-menu.restaurant', $restaurant->slug);

        return view('owner.qr-menu.index', compact(
            'restaurant',
            'tables',
            'stats',
            'topProducts',
            'restaurantQrUrl',
            'totalQrOrders',
            'todayQrOrders',
            'totalQrAmount',
            'todayQrAmount',
            'activeQrTables',
            'openQrOrders',
            'qrRevenue',
            'totalQrViews',
            'todayQrViews',
            'tableViews',
            'todayTableViews'
        ));
    }

    public function settings()
    {
        $restaurant = $this->restaurant();

        if (! $restaurant) {
            return redirect()->route('owner.login');
        }

        return view('owner.qr-menu.settings', compact('restaurant'));
    }

    public function update(Request $request)
    {
        return $this->updateSettings($request);
    }

    public function updateSettings(Request $request)
    {
        $restaurant = $this->restaurant();

        if (! $restaurant) {
            return redirect()->route('owner.login');
        }

        $validated = $request->validate([
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('restaurants', 'slug')->ignore($restaurant->id),
            ],
            'qr_is_active' => ['nullable', 'boolean'],
            'qr_welcome_text' => ['nullable', 'string', 'max:255'],
            'qr_about_title' => ['nullable', 'string', 'max:255'],
            'qr_about_description' => ['nullable', 'string', 'max:5000'],
            'qr_contact_phone' => ['nullable', 'string', 'max:50'],
            'qr_address' => ['nullable', 'string', 'max:500'],
            'qr_instagram' => ['nullable', 'url', 'max:500'],
            'qr_tiktok' => ['nullable', 'url', 'max:500'],
            'qr_facebook' => ['nullable', 'url', 'max:500'],
            'qr_website' => ['nullable', 'url', 'max:500'],
            'qr_background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data = [
            'slug' => Str::slug($validated['slug']),
            'qr_is_active' => $request->boolean('qr_is_active'),
            'qr_welcome_text' => $validated['qr_welcome_text'] ?? null,
            'qr_about_title' => $validated['qr_about_title'] ?? null,
            'qr_about_description' => $validated['qr_about_description'] ?? null,
            'qr_contact_phone' => $validated['qr_contact_phone'] ?? null,
            'qr_address' => $validated['qr_address'] ?? null,
            'qr_instagram' => $validated['qr_instagram'] ?? null,
            'qr_tiktok' => $validated['qr_tiktok'] ?? null,
            'qr_facebook' => $validated['qr_facebook'] ?? null,
            'qr_website' => $validated['qr_website'] ?? null,
        ];

        if ($request->hasFile('qr_background_image')) {
            if ($restaurant->qr_background_image) {
                Storage::disk('public')->delete($restaurant->qr_background_image);
            }

            $data['qr_background_image'] = $request
                ->file('qr_background_image')
                ->store('qr-menu/backgrounds', 'public');
        }

        $restaurant->update($data);

        return back()->with('success', 'QR menyu məlumatları yeniləndi.');
    }

    public function regenerateTableCode(RestaurantTable $table)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || (int) $table->restaurant_id !== (int) $restaurantId) {
            abort(403);
        }

        do {
            $code = strtoupper(Str::random(5));
        } while (
            RestaurantTable::where('code', $code)
            ->where('id', '!=', $table->id)
            ->exists()
        );

        $table->update(['code' => $code]);

        return back()->with('success', 'Masa QR kodu yeniləndi.');
    }

    private function restaurant(): ?Restaurant
    {
        $restaurantId = Session::get('owner_restaurant_id');

        return $restaurantId ? Restaurant::find($restaurantId) : null;
    }

    private function branchId(): ?int
    {
        return Session::get('owner_selected_branch_id')
            ?: Session::get('owner_branch_id');
    }
}
