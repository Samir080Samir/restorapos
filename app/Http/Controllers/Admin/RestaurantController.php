<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Restaurant;
use App\Services\AuditLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Güclü parol qaydaları
    |--------------------------------------------------------------------------
    */

    private function passwordRules(bool $required = true): array
    {
        return [

            $required ? 'required' : 'nullable',

            'string',

            'min:8',

            // minimum 1 kiçik hərf
            'regex:/[a-z]/',

            // minimum 1 böyük hərf
            'regex:/[A-Z]/',

            // minimum 1 rəqəm
            'regex:/[0-9]/',

            // minimum 1 simvol
            'regex:/[\W_]/',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Parol mesajları
    |--------------------------------------------------------------------------
    */

    private function passwordMessage(): array
    {
        return [

            'owner_password.required' =>
            'Owner parolu mütləq yazılmalıdır.',

            'owner_password.min' =>
            'Parol minimum 8 simvol olmalıdır.',

            'owner_password.regex' =>
            'Parolda böyük hərf, kiçik hərf, rəqəm və simvol olmalıdır.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Restoran siyahısı
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $restaurants = Restaurant::with([
            'plan',
            'branches',
            'latestLicense'
        ])
            ->latest()
            ->get();

        return view(
            'admin.restaurants.index',
            compact('restaurants')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Restoran yarat formu
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $plans = Plan::where('status', 'active')->get();

        return view(
            'admin.restaurants.create',
            compact('plans')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Restoran yarat
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'plan_id' =>
            'nullable|exists:plans,id',

            'name' =>
            'required|string|max:255',

            'owner_name' =>
            'nullable|string|max:255',

            'phone' =>
            'nullable|string|max:50',

            'email' =>
            'nullable|email|max:255',

            'owner_password' =>
            $this->passwordRules(true),

            'status' =>
            'required|in:active,inactive',

            'subscription_ends_at' =>
            'nullable|date',

            'logo' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ], $this->passwordMessage());

        $logo = null;

        /*
        |--------------------------------------------------------------------------
        | Logo upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            $logo = $request
                ->file('logo')
                ->store('restaurants', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Restoran yarat
        |--------------------------------------------------------------------------
        */

        $restaurant = Restaurant::create([

            'plan_id' =>
            $request->plan_id,

            'name' =>
            $request->name,

            'slug' =>
            Str::slug($request->name) . '-' . time(),

            'owner_name' =>
            $request->owner_name,

            'phone' =>
            $request->phone,

            'email' =>
            $request->email,

            'owner_password' =>
            Hash::make($request->owner_password),

            'logo' =>
            $logo,

            'status' =>
            $request->status,

            'subscription_ends_at' =>
            $request->subscription_ends_at,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit log
        |--------------------------------------------------------------------------
        */

        AuditLogger::log(
            module: 'restaurants',
            action: 'created',
            eventKey: 'audit.restaurants.created',
            description: 'Yeni restoran yaradıldı.',
            auditable: $restaurant,
            newValues: $restaurant->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | Paket seçilibsə lisenziya yarat
        |--------------------------------------------------------------------------
        */

        if ($request->plan_id) {

            $plan = Plan::find($request->plan_id);

            if ($plan) {

                $startDate = now();

                $endDate = $request->subscription_ends_at
                    ? Carbon::parse($request->subscription_ends_at)
                    : $startDate->copy()->addMonth();

                /*
                |--------------------------------------------------------------------------
                | License
                |--------------------------------------------------------------------------
                */

                $license = License::create([

                    'restaurant_id' =>
                    $restaurant->id,

                    'plan_id' =>
                    $plan->id,

                    'billing_cycle' =>
                    'monthly',

                    'start_date' =>
                    $startDate->toDateString(),

                    'end_date' =>
                    $endDate->toDateString(),

                    'status' =>
                    $request->status === 'active'
                        ? 'active'
                        : 'suspended',

                    'amount' =>
                    $plan->monthly_price,

                    'last_payment_date' =>
                    null,

                    'next_payment_date' =>
                    $endDate->toDateString(),

                    'auto_suspend' =>
                    true,

                    'suspended_at' =>
                    $request->status === 'active'
                        ? null
                        : now(),

                    'suspend_reason' =>
                    $request->status === 'active'
                        ? null
                        : 'Restoran yaradılarkən deaktiv status seçildi.',

                    'note' =>
                    'Restoran yaradılarkən avtomatik lisenziya açıldı.',
                ]);

                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                Payment::create([

                    'restaurant_id' =>
                    $restaurant->id,

                    'license_id' =>
                    $license->id,

                    'plan_id' =>
                    $plan->id,

                    'amount' =>
                    $plan->monthly_price,

                    'billing_cycle' =>
                    'monthly',

                    'payment_method' =>
                    'manual',

                    'status' =>
                    'pending',

                    'payment_date' =>
                    null,

                    'transaction_id' =>
                    null,

                    'note' =>
                    'Restoran yaradılarkən avtomatik pending ödəniş yaradıldı.',
                ]);

                /*
                |--------------------------------------------------------------------------
                | Subscription bitmə tarixi
                |--------------------------------------------------------------------------
                */

                $restaurant->update([
                    'subscription_ends_at' =>
                    $endDate->toDateString(),
                ]);
            }
        }

        return redirect()
            ->route('admin.restaurants.index')
            ->with(
                'success',
                'Restoran uğurla əlavə edildi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit formu
    |--------------------------------------------------------------------------
    */

    public function edit(Restaurant $restaurant)
    {
        $plans = Plan::where('status', 'active')->get();

        return view(
            'admin.restaurants.edit',
            compact('restaurant', 'plans')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Restaurant $restaurant
    ) {

        $request->validate([

            'plan_id' =>
            'nullable|exists:plans,id',

            'name' =>
            'required|string|max:255',

            'owner_name' =>
            'nullable|string|max:255',

            'phone' =>
            'nullable|string|max:50',

            'email' =>
            'nullable|email|max:255',

            'owner_password' =>
            $this->passwordRules(false),

            'status' =>
            'required|in:active,inactive',

            'subscription_ends_at' =>
            'nullable|date',

            'logo' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'remove_logo' =>
            'nullable|boolean',

        ], $this->passwordMessage());

        /*
        |--------------------------------------------------------------------------
        | Köhnə dəyərlər
        |--------------------------------------------------------------------------
        */

        $oldValues = $restaurant->toArray();

        /*
        |--------------------------------------------------------------------------
        | Logo sil
        |--------------------------------------------------------------------------
        */

        if (
            $request->boolean('remove_logo')
            && $restaurant->logo
        ) {

            Storage::disk('public')
                ->delete($restaurant->logo);

            $restaurant->update([
                'logo' => null,
            ]);

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Loqo silindi.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Yeni logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            if ($restaurant->logo) {

                Storage::disk('public')
                    ->delete($restaurant->logo);
            }

            $restaurant->logo = $request
                ->file('logo')
                ->store('restaurants', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Parol dəyişimi
        |--------------------------------------------------------------------------
        */

        $ownerPassword = $restaurant->owner_password;

        if ($request->filled('owner_password')) {

            $ownerPassword = Hash::make(
                $request->owner_password
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $restaurant->update([

            'plan_id' =>
            $request->plan_id,

            'name' =>
            $request->name,

            'owner_name' =>
            $request->owner_name,

            'phone' =>
            $request->phone,

            'email' =>
            $request->email,

            'owner_password' =>
            $ownerPassword,

            'logo' =>
            $restaurant->logo,

            'status' =>
            $request->status,

            'subscription_ends_at' =>
            $request->subscription_ends_at,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit
        |--------------------------------------------------------------------------
        */

        AuditLogger::log(
            module: 'restaurants',
            action: 'updated',
            eventKey: 'audit.restaurants.updated',
            description: 'Restoran məlumatları yeniləndi.',
            auditable: $restaurant,
            oldValues: $oldValues,
            newValues: $restaurant->fresh()->toArray()
        );

        return redirect()
            ->route('admin.restaurants.index')
            ->with(
                'success',
                'Restoran məlumatları yeniləndi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(Restaurant $restaurant)
    {
        $oldValues = $restaurant->toArray();

        if ($restaurant->logo) {

            Storage::disk('public')
                ->delete($restaurant->logo);
        }

        AuditLogger::log(
            module: 'restaurants',
            action: 'deleted',
            eventKey: 'audit.restaurants.deleted',
            description: 'Restoran silindi.',
            auditable: $restaurant,
            oldValues: $oldValues
        );

        $restaurant->delete();

        return redirect()
            ->route('admin.restaurants.index')
            ->with(
                'success',
                'Restoran silindi.'
            );
    }
}
