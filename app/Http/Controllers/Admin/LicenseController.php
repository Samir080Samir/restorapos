<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Plan;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Lisenziyaların siyahısı.
     */
    public function index()
    {
        $licenses = License::with(['restaurant', 'plan'])
            ->latest()
            ->get();

        return view('admin.licenses.index', compact('licenses'));
    }

    /**
     * Yeni lisenziya yaratma səhifəsi.
     */
    public function create()
    {
        $restaurants = Restaurant::orderBy('name')->get();
        $plans = Plan::where('status', 'active')->orderBy('name')->get();

        return view('admin.licenses.create', compact('restaurants', 'plans'));
    }

    /**
     * Yeni lisenziyanı bazaya yazır.
     */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|in:monthly,yearly',
            'start_date' => 'required|date',
            'status' => 'required|in:active,expired,suspended,cancelled',
            'amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:2000',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        $startDate = Carbon::parse($request->start_date);

        $endDate = $request->billing_cycle === 'yearly'
            ? $startDate->copy()->addYear()
            : $startDate->copy()->addMonth();

        $amount = $request->amount;

        if ($amount === null) {
            $amount = $request->billing_cycle === 'yearly'
                ? $plan->yearly_price
                : $plan->monthly_price;
        }

        License::create([
            'restaurant_id' => $request->restaurant_id,
            'plan_id' => $request->plan_id,

            'billing_cycle' => $request->billing_cycle,

            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),

            'status' => $request->status,

            'amount' => $amount,

            'last_payment_date' => $startDate->toDateString(),
            'next_payment_date' => $endDate->toDateString(),

            'auto_suspend' => $request->has('auto_suspend'),

            'note' => $request->note,
        ]);

        Restaurant::where('id', $request->restaurant_id)->update([
            'plan_id' => $request->plan_id,
            'status' => $request->status === 'active' ? 'active' : 'inactive',
            'subscription_ends_at' => $endDate,
        ]);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'Lisenziya uğurla yaradıldı.');
    }

    /**
     * Lisenziyanı redaktə etmə səhifəsi.
     */
    public function edit(License $license)
    {
        $restaurants = Restaurant::orderBy('name')->get();
        $plans = Plan::where('status', 'active')->orderBy('name')->get();

        return view('admin.licenses.edit', compact('license', 'restaurants', 'plans'));
    }

    /**
     * Lisenziyanı yeniləyir.
     */
    public function update(Request $request, License $license)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|in:monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,expired,suspended,cancelled',
            'amount' => 'nullable|numeric|min:0',
            'last_payment_date' => 'nullable|date',
            'next_payment_date' => 'nullable|date',
            'note' => 'nullable|string|max:2000',
        ]);

        $license->update([
            'restaurant_id' => $request->restaurant_id,
            'plan_id' => $request->plan_id,

            'billing_cycle' => $request->billing_cycle,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

            'status' => $request->status,

            'amount' => $request->amount ?? 0,

            'last_payment_date' => $request->last_payment_date,
            'next_payment_date' => $request->next_payment_date,

            'auto_suspend' => $request->has('auto_suspend'),

            'suspended_at' => $request->status === 'suspended' ? now() : null,
            'suspend_reason' => $request->status === 'suspended'
                ? 'Admin tərəfindən dayandırıldı'
                : null,

            'note' => $request->note,
        ]);

        $restaurantStatus = $request->status === 'active'
            && Carbon::parse($request->end_date)->greaterThanOrEqualTo(now())
            ? 'active'
            : 'inactive';

        Restaurant::where('id', $request->restaurant_id)->update([
            'plan_id' => $request->plan_id,
            'status' => $restaurantStatus,
            'subscription_ends_at' => $request->end_date,
        ]);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'Lisenziya məlumatları yeniləndi.');
    }

    /**
     * Lisenziyanı silir.
     */
    public function destroy(License $license)
    {
        $license->delete();

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'Lisenziya silindi.');
    }
}
