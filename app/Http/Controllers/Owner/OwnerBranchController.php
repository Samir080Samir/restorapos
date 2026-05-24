<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class OwnerBranchController extends Controller
{
    public function index()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $branches = Branch::where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.branches.index', compact('branches'));
    }

    public function edit(Branch $branch)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || $branch->restaurant_id != $restaurantId) {
            abort(403);
        }

        return view('owner.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || $branch->restaurant_id != $restaurantId) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $branch->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('owner.branches.index')
            ->with('success', 'Filial məlumatları yeniləndi.');
    }

    public function switch(Request $request)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $branchId = $request->branch_id;

        if ($branchId) {
            $branch = Branch::where('restaurant_id', $restaurantId)
                ->where('id', $branchId)
                ->firstOrFail();

            Session::put('owner_selected_branch_id', $branch->id);
            Session::put('owner_selected_branch_name', $branch->name);
        } else {
            Session::forget([
                'owner_selected_branch_id',
                'owner_selected_branch_name',
            ]);
        }

        return back();
    }
}
