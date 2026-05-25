<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        $restaurantId = session('staff_restaurant_id');
        $branchId = session('staff_branch_id');
        $q = trim($request->query('q', ''));

        if (! $restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran sessiyası tapılmadı.',
                'customers' => [],
            ], 403);
        }

        $customers = Customer::query()
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($sub) use ($branchId) {
                    $sub->whereNull('branch_id')
                        ->orWhere('branch_id', $branchId);
                });
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('full_name', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'customers' => $customers->map(fn($customer) => [
                'id' => $customer->id,
                'full_name' => $customer->full_name,
                'phone' => $customer->phone,
                'note' => $customer->note,
                'bonus_balance' => (float) $customer->bonus_balance,
                'total_debt' => (float) $customer->total_debt,
                'status' => $customer->status,
            ])->values(),
        ]);
    }

    public function store(Request $request)
    {
        $restaurantId = session('staff_restaurant_id');
        $branchId = session('staff_branch_id');

        if (! $restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran sessiyası tapılmadı.',
            ], 403);
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $customer = Customer::create([
            'restaurant_id' => $restaurantId,
            'branch_id' => $branchId ?: null,
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'] ?? null,
            'note' => $validated['note'] ?? null,
            'bonus_balance' => 0,
            'total_debt' => 0,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Müştəri yadda saxlanıldı.',
            'customer' => [
                'id' => $customer->id,
                'full_name' => $customer->full_name,
                'phone' => $customer->phone,
                'note' => $customer->note,
                'bonus_balance' => (float) $customer->bonus_balance,
                'total_debt' => (float) $customer->total_debt,
                'status' => $customer->status,
            ],
        ]);
    }
}
