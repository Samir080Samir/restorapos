<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    /**
     * Filialların siyahısı.
     */
    public function index()
    {
        $branches = Branch::with(['restaurant.plan'])
            ->latest()
            ->get();

        $totalBranches = Branch::count();
        $activeBranches = Branch::where('status', 'active')->count();
        $inactiveBranches = Branch::where('status', 'inactive')->count();
        $onlineBranches = Branch::where('live_status', 'online')->count();

        return view('admin.branches.index', compact(
            'branches',
            'totalBranches',
            'activeBranches',
            'inactiveBranches',
            'onlineBranches'
        ));
    }

    /**
     * Yeni filial əlavə etmə səhifəsi.
     */
    public function create()
    {
        $restaurants = Restaurant::where('status', 'active')->get();

        return view('admin.branches.create', compact('restaurants'));
    }

    /**
     * Yeni filialı bazaya əlavə edir.
     */
    public function store(Request $request)
    {
        $data = $this->validateBranch($request);

        $data['qr_menu_enabled'] = $request->has('qr_menu_enabled');
        $data['pos_terminals_count'] = $request->pos_terminals_count ?? 0;
        $data['kds_count'] = $request->kds_count ?? 0;
        $data['printer_count'] = $request->printer_count ?? 0;
        $data['debt_amount'] = $request->debt_amount ?? 0;

        // Logo upload
        if ($request->hasFile('logo')) {

            $data['logo'] = $request->file('logo')
                ->store('branches', 'public');
        }

        Branch::create($data);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Filial uğurla əlavə edildi.');
    }

    /**
     * Filial redaktə səhifəsi.
     */
    public function edit(Branch $branch)
    {
        $restaurants = Restaurant::where('status', 'active')->get();

        return view('admin.branches.edit', compact(
            'branch',
            'restaurants'
        ));
    }

    /**
     * Filial məlumatlarını yeniləyir.
     */
    public function update(Request $request, Branch $branch)
    {
        // Logo sil
        if ($request->boolean('remove_logo') && $branch->logo) {

            Storage::disk('public')->delete($branch->logo);

            $branch->update([
                'logo' => null,
            ]);

            return redirect()
                ->back()
                ->with('success', 'Filial loqosu silindi.');
        }

        $data = $this->validateBranch($request);

        $data['qr_menu_enabled'] = $request->has('qr_menu_enabled');
        $data['pos_terminals_count'] = $request->pos_terminals_count ?? 0;
        $data['kds_count'] = $request->kds_count ?? 0;
        $data['printer_count'] = $request->printer_count ?? 0;
        $data['debt_amount'] = $request->debt_amount ?? 0;

        // Yeni logo yüklə
        if ($request->hasFile('logo')) {

            // Köhnə logo sil
            if ($branch->logo) {

                Storage::disk('public')
                    ->delete($branch->logo);
            }

            $data['logo'] = $request->file('logo')
                ->store('branches', 'public');
        } else {

            $data['logo'] = $branch->logo;
        }

        $branch->update($data);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Filial məlumatları yeniləndi.');
    }

    /**
     * Filialı silir.
     */
    public function destroy(Branch $branch)
    {
        // Logo sil
        if ($branch->logo) {

            Storage::disk('public')
                ->delete($branch->logo);
        }

        $branch->delete();

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Filial silindi.');
    }

    /**
     * Validation qaydaları.
     */
    private function validateBranch(Request $request): array
    {
        return $request->validate([

            'restaurant_id' => 'required|exists:restaurants,id',

            'name' => 'required|string|max:255',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'remove_logo' => 'nullable|boolean',

            'phone' => 'nullable|string|max:50',

            'address' => 'nullable|string|max:255',

            'manager_name' => 'nullable|string|max:255',

            'city' => 'nullable|string|max:255',

            'status' => 'required|string',

            'branch_type' => 'required|string',

            'live_status' => 'required|string',

            'pos_terminals_count' => 'nullable|integer|min:0',

            'kds_count' => 'nullable|integer|min:0',

            'printer_count' => 'nullable|integer|min:0',

            'qr_menu_enabled' => 'nullable|boolean',

            'last_payment_date' => 'nullable|date',

            'next_payment_date' => 'nullable|date',

            'debt_amount' => 'nullable|numeric|min:0',

            'opens_at' => 'nullable',

            'closes_at' => 'nullable',
        ]);
    }
}
