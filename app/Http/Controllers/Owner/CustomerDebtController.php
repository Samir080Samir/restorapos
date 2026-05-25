<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDebt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerDebtController extends Controller
{
    public function index(Request $request)
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $debts = CustomerDebt::query()
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($sub) use ($branchId) {
                    $sub->whereNull('branch_id')
                        ->orWhere('branch_id', $branchId);
                });
            })
            ->with([
                'customer',
                'staff',
                'order',
            ])
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = trim($request->q);

                $query->where(function ($main) use ($search) {
                    $main->whereHas('customer', function ($sub) use ($search) {
                        $sub->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })
                        ->orWhereHas('order', function ($sub) use ($search) {
                            $sub->where('order_number', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $summaryQuery = CustomerDebt::query()
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($sub) use ($branchId) {
                    $sub->whereNull('branch_id')
                        ->orWhere('branch_id', $branchId);
                });
            });

        $summary = (clone $summaryQuery)
            ->selectRaw('
                COALESCE(SUM(amount), 0) as total_amount,
                COALESCE(SUM(paid_amount), 0) as total_paid,
                COALESCE(SUM(remaining_amount), 0) as total_remaining
            ')
            ->first();

        $activeDebtsCount = (clone $summaryQuery)
            ->whereIn('status', ['unpaid', 'partial'])
            ->count();

        $paidDebtsCount = (clone $summaryQuery)
            ->where('status', 'paid')
            ->count();

        return view('owner.customer-debts.index', compact(
            'debts',
            'summary',
            'activeDebtsCount',
            'paidDebtsCount'
        ));
    }

    public function pay(Request $request, CustomerDebt $debt)
    {
        $this->checkDebt($debt);

        $request->validate([
            'paid_amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $debt) {
            $debt = CustomerDebt::where('id', $debt->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($debt->status === 'paid' || (float) $debt->remaining_amount <= 0) {
                return;
            }

            $paidAmount = round((float) $request->paid_amount, 2);
            $currentRemaining = round((float) $debt->remaining_amount, 2);

            $paidAmount = min($paidAmount, $currentRemaining);

            $newPaid = round((float) $debt->paid_amount + $paidAmount, 2);
            $remaining = round(max(0, (float) $debt->amount - $newPaid), 2);

            $debt->update([
                'paid_amount' => $newPaid,
                'remaining_amount' => $remaining,
                'status' => $remaining <= 0 ? 'paid' : 'partial',
                'paid_at' => $remaining <= 0 ? now() : $debt->paid_at,
                'note' => $request->filled('note') ? $request->note : $debt->note,
            ]);

            $this->refreshCustomerDebt((int) $debt->customer_id);
        });

        return back()->with('success', 'Borc ödənişi qeyd edildi.');
    }

    public function close(Request $request, CustomerDebt $debt)
    {
        $this->checkDebt($debt);

        $request->validate([
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $debt) {
            $debt = CustomerDebt::where('id', $debt->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($debt->status === 'paid' || (float) $debt->remaining_amount <= 0) {
                return;
            }

            $debt->update([
                'paid_amount' => round((float) $debt->amount, 2),
                'remaining_amount' => 0,
                'status' => 'paid',
                'paid_at' => now(),
                'note' => $request->filled('note') ? $request->note : $debt->note,
            ]);

            $this->refreshCustomerDebt((int) $debt->customer_id);
        });

        return back()->with('success', 'Borc tam bağlandı.');
    }

    private function checkDebt(CustomerDebt $debt): void
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        abort_if(! $restaurantId || (int) $debt->restaurant_id !== (int) $restaurantId, 403);

        if ($branchId && $debt->branch_id && (int) $debt->branch_id !== (int) $branchId) {
            abort(403);
        }
    }

    private function refreshCustomerDebt(int $customerId): void
    {
        $total = CustomerDebt::where('customer_id', $customerId)
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum('remaining_amount');

        Customer::where('id', $customerId)->update([
            'total_debt' => round((float) $total, 2),
        ]);
    }
}
