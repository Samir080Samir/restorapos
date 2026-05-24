<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Plan;

class DashboardController extends Controller
{
    /**
     * Super Admin əsas idarə paneli.
     */
    public function index()
    {
        $totalRestaurants = Restaurant::count();

        $activeRestaurants = Restaurant::where('status', 'active')->count();

        $inactiveRestaurants = Restaurant::where('status', 'inactive')->count();

        $totalPlans = Plan::count();

        $activePlans = Plan::where('status', 'active')->count();

        $newRestaurantsThisMonth = Restaurant::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $expiringCount = Restaurant::whereNotNull('subscription_ends_at')
            ->whereDate('subscription_ends_at', '<=', now()->addDays(7))
            ->count();

        $latestRestaurants = Restaurant::latest()
            ->take(5)
            ->get();

        $expiringRestaurants = Restaurant::whereNotNull('subscription_ends_at')
            ->whereDate('subscription_ends_at', '<=', now()->addDays(7))
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRestaurants',
            'activeRestaurants',
            'inactiveRestaurants',
            'totalPlans',
            'activePlans',
            'newRestaurantsThisMonth',
            'expiringCount',
            'latestRestaurants',
            'expiringRestaurants'
        ));
    }
}