<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $customers = Customer::query()
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, fn($q) => $q->where(function ($sub) use ($branchId) {
                $sub->whereNull('branch_id')->orWhere('branch_id', $branchId);
            }))
            ->withCount('debts')
            ->withSum(['activeDebts as active_debt_sum'], 'remaining_amount')
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = trim($request->q);

                $q->where(function ($sub) use ($search) {
                    $sub->where('full_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('owner.customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        Customer::create([
            'restaurant_id' => $restaurantId,
            'branch_id' => $branchId ?: null,
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'] ?? null,
            'note' => $validated['note'] ?? null,
            'bonus_balance' => 0,
            'total_debt' => 0,
            'status' => 'active',
        ]);

        return redirect()
            ->route('owner.customers.index')
            ->with('success', 'Müştəri əlavə edildi.');
    }

    public function show(Customer $customer)
    {
        $this->checkCustomer($customer);

        $customer->load([
            'branch',
            'debts' => fn($q) => $q->with(['order', 'staff'])->latest(),
        ]);

        return view('owner.customers.show', compact('customer'));
    }

    private function checkCustomer(Customer $customer): void
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        abort_if(! $restaurantId || (int) $customer->restaurant_id !== (int) $restaurantId, 403);

        if ($branchId && $customer->branch_id && (int) $customer->branch_id !== (int) $branchId) {
            abort(403);
        }
    }
}
