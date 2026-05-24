<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Plan;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Kampaniyaların siyahısı.
     */
    public function index()
    {
        $campaigns = Campaign::with('plan')
            ->latest()
            ->get();

        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Yeni kampaniya əlavə etmə səhifəsi.
     */
    public function create()
    {
        $plans = Plan::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.campaigns.create', compact('plans'));
    }

    /**
     * Yeni kampaniyanı bazaya əlavə edir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:discount,promo_code,referral,trial,plan_upgrade,seasonal',
            'discount_type' => 'required|in:percentage,fixed,free_month',
            'discount_value' => 'required|numeric|min:0',
            'promo_code' => 'nullable|string|max:100|unique:campaigns,promo_code',
            'plan_id' => 'nullable|exists:plans,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:3000',
            'terms' => 'nullable|string|max:3000',
        ]);

        $campaign = Campaign::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),

            'type' => $request->type,

            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,

            'promo_code' => $request->promo_code
                ? strtoupper($request->promo_code)
                : null,

            'plan_id' => $request->plan_id,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

            'usage_limit' => $request->usage_limit,
            'used_count' => 0,

            'applies_to_monthly' => $request->has('applies_to_monthly'),
            'applies_to_yearly' => $request->has('applies_to_yearly'),

            'is_active' => $request->has('is_active'),

            'description' => $request->description,
            'terms' => $request->terms,
        ]);

        AuditLogger::log(
            module: 'campaigns',
            action: 'created',
            eventKey: 'audit.campaigns.created',
            description: 'Yeni kampaniya yaradıldı.',
            auditable: $campaign,
            newValues: $campaign->toArray()
        );

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Kampaniya uğurla əlavə edildi.');
    }

    /**
     * Kampaniyanı redaktə etmə səhifəsi.
     */
    public function edit(Campaign $campaign)
    {
        $plans = Plan::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.campaigns.edit', compact('campaign', 'plans'));
    }

    /**
     * Kampaniya məlumatlarını yeniləyir.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:discount,promo_code,referral,trial,plan_upgrade,seasonal',
            'discount_type' => 'required|in:percentage,fixed,free_month',
            'discount_value' => 'required|numeric|min:0',
            'promo_code' => 'nullable|string|max:100|unique:campaigns,promo_code,' . $campaign->id,
            'plan_id' => 'nullable|exists:plans,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'used_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:3000',
            'terms' => 'nullable|string|max:3000',
        ]);

        $oldValues = $campaign->toArray();

        $campaign->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $campaign->id,

            'type' => $request->type,

            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,

            'promo_code' => $request->promo_code
                ? strtoupper($request->promo_code)
                : null,

            'plan_id' => $request->plan_id,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

            'usage_limit' => $request->usage_limit,
            'used_count' => $request->used_count ?? $campaign->used_count,

            'applies_to_monthly' => $request->has('applies_to_monthly'),
            'applies_to_yearly' => $request->has('applies_to_yearly'),

            'is_active' => $request->has('is_active'),

            'description' => $request->description,
            'terms' => $request->terms,
        ]);

        AuditLogger::log(
            module: 'campaigns',
            action: 'updated',
            eventKey: 'audit.campaigns.updated',
            description: 'Kampaniya məlumatları yeniləndi.',
            auditable: $campaign,
            oldValues: $oldValues,
            newValues: $campaign->fresh()->toArray()
        );

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Kampaniya məlumatları yeniləndi.');
    }

    /**
     * Kampaniyanı silir.
     */
    public function destroy(Campaign $campaign)
    {
        $oldValues = $campaign->toArray();

        AuditLogger::log(
            module: 'campaigns',
            action: 'deleted',
            eventKey: 'audit.campaigns.deleted',
            description: 'Kampaniya silindi.',
            auditable: $campaign,
            oldValues: $oldValues
        );

        $campaign->delete();

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Kampaniya silindi.');
    }
}
