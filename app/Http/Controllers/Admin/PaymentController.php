<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\License;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Restaurant;
use App\Services\AuditLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Ödənişlərin siyahısı.
     */
    public function index()
    {
        $payments = Payment::with(['restaurant', 'license', 'plan'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Yeni ödəniş yaratma səhifəsi.
     */
    public function create()
    {
        $restaurants = Restaurant::orderBy('name')->get();

        $licenses = License::with(['restaurant', 'plan'])
            ->latest()
            ->get();

        $plans = Plan::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.payments.create', compact(
            'restaurants',
            'licenses',
            'plans'
        ));
    }

    /**
     * Yeni ödənişi bazaya yazır.
     */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'license_id' => 'nullable|exists:licenses,id',
            'plan_id' => 'nullable|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'payment_method' => 'required|in:cash,bank_transfer,card,online,manual',
            'status' => 'required|in:paid,pending,failed,refunded,cancelled',
            'payment_date' => 'nullable|date',
            'transaction_id' => 'nullable|string|max:255',
            'promo_code' => 'nullable|string|max:100',
            'note' => 'nullable|string|max:2000',
        ]);

        $paymentDate = $request->payment_date
            ? Carbon::parse($request->payment_date)
            : now();

        $originalAmount = (float) $request->amount;
        $finalAmount = $originalAmount;
        $discountAmount = 0;
        $campaign = null;

        if ($request->filled('promo_code')) {

            $promoCode = strtoupper(trim($request->promo_code));

            $campaign = Campaign::where('promo_code', $promoCode)
                ->where('is_active', true)
                ->first();

            if (! $campaign || ! $campaign->isActive()) {

                return back()
                    ->withErrors([
                        'promo_code' => 'Promo kod aktiv deyil, müddəti bitib və ya istifadə limiti dolub.',
                    ])
                    ->withInput();
            }

            if ($campaign->plan_id && $request->plan_id && $campaign->plan_id != $request->plan_id) {

                return back()
                    ->withErrors([
                        'promo_code' => 'Bu promo kod seçilmiş paket üçün keçərli deyil.',
                    ])
                    ->withInput();
            }

            if ($request->billing_cycle === 'monthly' && ! $campaign->applies_to_monthly) {

                return back()
                    ->withErrors([
                        'promo_code' => 'Bu promo kod aylıq ödəniş üçün keçərli deyil.',
                    ])
                    ->withInput();
            }

            if ($request->billing_cycle === 'yearly' && ! $campaign->applies_to_yearly) {

                return back()
                    ->withErrors([
                        'promo_code' => 'Bu promo kod illik ödəniş üçün keçərli deyil.',
                    ])
                    ->withInput();
            }

            if ($campaign->discount_type === 'percentage') {

                $discountAmount = ($originalAmount * (float) $campaign->discount_value) / 100;
            } elseif ($campaign->discount_type === 'fixed') {

                $discountAmount = (float) $campaign->discount_value;
            } elseif ($campaign->discount_type === 'free_month') {

                $discountAmount = 0;
            }

            $finalAmount = max(0, $originalAmount - $discountAmount);
        }

        $note = $request->note;

        if ($campaign) {

            $note = trim(
                ($note ?? '') .
                    "\n\nPromo kod: {$campaign->promo_code}. İlkin məbləğ: ₼{$originalAmount}. Endirim: ₼" .
                    number_format($discountAmount, 2) .
                    ". Yekun məbləğ: ₼" .
                    number_format($finalAmount, 2) .
                    "."
            );
        }

        $payment = Payment::create([
            'restaurant_id' => $request->restaurant_id,
            'license_id' => $request->license_id,
            'plan_id' => $request->plan_id,

            'amount' => $finalAmount,

            'billing_cycle' => $request->billing_cycle,
            'payment_method' => $request->payment_method,
            'status' => $request->status,

            'payment_date' => $paymentDate->toDateString(),
            'transaction_id' => $request->transaction_id,

            'note' => $note,
        ]);

        AuditLogger::log(
            module: 'payments',
            action: 'created',
            eventKey: 'audit.payments.created',
            description: 'Yeni ödəniş yaradıldı.',
            auditable: $payment,
            newValues: $payment->toArray()
        );

        if ($campaign && $payment->status === 'paid') {

            $campaign->increment('used_count');

            AuditLogger::log(
                module: 'campaigns',
                action: 'updated',
                eventKey: 'audit.campaigns.used',
                description: 'Promo kod istifadə edildi.',
                auditable: $campaign,
                newValues: $campaign->fresh()->toArray()
            );
        }

        /**
         * Əgər ödəniş uğurludursa və lisenziya seçilibsə,
         * lisenziyanı avtomatik yenilə.
         */
        if ($payment->status === 'paid' && $payment->license_id) {

            $license = License::find($payment->license_id);

            if ($license) {

                $oldLicense = $license->toArray();

                $startDate = now()->greaterThan($license->end_date)
                    ? now()
                    : Carbon::parse($license->end_date);

                $newEndDate = $payment->billing_cycle === 'yearly'
                    ? $startDate->copy()->addYear()
                    : $startDate->copy()->addMonth();

                if ($campaign && $campaign->discount_type === 'free_month') {
                    $newEndDate = $startDate->copy()->addMonths((int) $campaign->discount_value);
                }

                $license->update([
                    'status' => 'active',
                    'billing_cycle' => $payment->billing_cycle,
                    'amount' => $payment->amount,
                    'last_payment_date' => $paymentDate->toDateString(),
                    'next_payment_date' => $newEndDate->toDateString(),
                    'end_date' => $newEndDate->toDateString(),
                    'suspended_at' => null,
                    'suspend_reason' => null,
                ]);

                AuditLogger::log(
                    module: 'licenses',
                    action: 'updated',
                    eventKey: 'audit.licenses.renewed',
                    description: 'Lisenziya yeniləndi.',
                    auditable: $license,
                    oldValues: $oldLicense,
                    newValues: $license->fresh()->toArray()
                );

                if ($license->restaurant) {

                    $oldRestaurant = $license->restaurant->toArray();

                    $license->restaurant->update([
                        'status' => 'active',
                        'plan_id' => $license->plan_id,
                        'subscription_ends_at' => $newEndDate->toDateString(),
                    ]);

                    AuditLogger::log(
                        module: 'restaurants',
                        action: 'updated',
                        eventKey: 'audit.restaurants.subscription_updated',
                        description: 'Restoran abunəliyi yeniləndi.',
                        auditable: $license->restaurant,
                        oldValues: $oldRestaurant,
                        newValues: $license->restaurant->fresh()->toArray()
                    );
                }
            }
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Ödəniş uğurla əlavə edildi.');
    }

    /**
     * Ödənişi redaktə etmə səhifəsi.
     */
    public function edit(Payment $payment)
    {
        $restaurants = Restaurant::orderBy('name')->get();

        $licenses = License::with(['restaurant', 'plan'])
            ->latest()
            ->get();

        $plans = Plan::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.payments.edit', compact(
            'payment',
            'restaurants',
            'licenses',
            'plans'
        ));
    }

    /**
     * Ödənişi yeniləyir.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'license_id' => 'nullable|exists:licenses,id',
            'plan_id' => 'nullable|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'payment_method' => 'required|in:cash,bank_transfer,card,online,manual',
            'status' => 'required|in:paid,pending,failed,refunded,cancelled',
            'payment_date' => 'nullable|date',
            'transaction_id' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:2000',
        ]);

        $oldValues = $payment->toArray();

        $payment->update([
            'restaurant_id' => $request->restaurant_id,
            'license_id' => $request->license_id,
            'plan_id' => $request->plan_id,
            'amount' => $request->amount,
            'billing_cycle' => $request->billing_cycle,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
            'transaction_id' => $request->transaction_id,
            'note' => $request->note,
        ]);

        AuditLogger::log(
            module: 'payments',
            action: 'updated',
            eventKey: 'audit.payments.updated',
            description: 'Ödəniş məlumatları yeniləndi.',
            auditable: $payment,
            oldValues: $oldValues,
            newValues: $payment->fresh()->toArray()
        );

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Ödəniş məlumatları yeniləndi.');
    }

    /**
     * Ödənişi silir.
     */
    public function destroy(Payment $payment)
    {
        $oldValues = $payment->toArray();

        AuditLogger::log(
            module: 'payments',
            action: 'deleted',
            eventKey: 'audit.payments.deleted',
            description: 'Ödəniş silindi.',
            auditable: $payment,
            oldValues: $oldValues
        );

        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Ödəniş silindi.');
    }
}
