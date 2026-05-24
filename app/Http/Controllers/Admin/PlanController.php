<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    /**
     * Paketlərin siyahısı.
     */
    public function index()
    {
        $plans = Plan::latest()->get();

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Yeni paket əlavə etmə səhifəsi.
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Yeni paketi bazaya əlavə edir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'max_branches' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:1',
            'max_tables' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        Plan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),

            'monthly_price' => $request->monthly_price,
            'yearly_price' => $request->yearly_price,

            'max_branches' => $request->max_branches,
            'max_users' => $request->max_users,
            'max_tables' => $request->max_tables,

            'qr_menu' => $request->has('qr_menu'),
            'waiter_app' => $request->has('waiter_app'),
            'kitchen_display' => $request->has('kitchen_display'),
            'kiosk' => $request->has('kiosk'),
            'inventory' => $request->has('inventory'),
            'reports' => $request->has('reports'),
            'multi_branch' => $request->has('multi_branch'),

            'status' => $request->status,
            'is_popular' => $request->has('is_popular'),
        ]);

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Paket uğurla əlavə edildi.');
    }

    /**
     * Paketi redaktə etmə səhifəsi.
     */
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Paket məlumatlarını yeniləyir.
     */
    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'max_branches' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:1',
            'max_tables' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $plan->update([
            'name' => $request->name,

            'monthly_price' => $request->monthly_price,
            'yearly_price' => $request->yearly_price,

            'max_branches' => $request->max_branches,
            'max_users' => $request->max_users,
            'max_tables' => $request->max_tables,

            'qr_menu' => $request->has('qr_menu'),
            'waiter_app' => $request->has('waiter_app'),
            'kitchen_display' => $request->has('kitchen_display'),
            'kiosk' => $request->has('kiosk'),
            'inventory' => $request->has('inventory'),
            'reports' => $request->has('reports'),
            'multi_branch' => $request->has('multi_branch'),

            'status' => $request->status,
            'is_popular' => $request->has('is_popular'),
        ]);

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Paket məlumatları yeniləndi.');
    }

    /**
     * Paketi silir.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Paket silindi.');
    }
}
