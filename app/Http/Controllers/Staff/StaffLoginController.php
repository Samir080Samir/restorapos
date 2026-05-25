<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DiningArea;
use App\Models\MenuCategory;
use App\Models\PosTerminal;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StaffLoginController extends Controller
{
    public function login()
    {
        return view('staff_auth.login');
    }

    public function checkTerminal(Request $request)
    {
        $request->validate([
            'terminal_code' => ['required', 'string', 'max:50'],
        ]);

        $code = strtoupper(trim($request->terminal_code));

        $terminal = PosTerminal::with(['restaurant', 'branch'])
            ->whereRaw('UPPER(activation_code) = ?', [$code])
            ->where('is_active', true)
            ->first();

        if (! $terminal) {
            return response()->json([
                'success' => false,
                'message' => 'Terminal kodu tapılmadı və ya aktiv deyil.',
            ]);
        }

        $terminal->update([
            'last_used_at' => now(),
        ]);

        Session::forget([
            'staff_user_id',
            'staff_user_name',
            'staff_user_role',
            'staff_user_branch_id',
        ]);

        Session::put([
            'staff_terminal_id' => $terminal->id,
            'staff_terminal_code' => $terminal->activation_code,

            'staff_restaurant_id' => $terminal->restaurant_id,
            'staff_restaurant_name' => $terminal->restaurant->name ?? 'Restoran',

            'staff_branch_id' => $terminal->branch_id,
            'staff_branch_name' => $terminal->branch
                ? $terminal->branch->name
                : 'Ümumi restoran',
        ]);

        return response()->json([
            'success' => true,
            'terminal_code' => $terminal->activation_code,
            'restaurant_name' => $terminal->restaurant->name ?? 'Restoran',
            'branch_name' => $terminal->branch
                ? $terminal->branch->name
                : 'Ümumi restoran',
        ]);
    }

    public function pinLogin(Request $request)
    {
        if (! Session::has('staff_terminal_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Əvvəlcə terminal kodunu təsdiqləyin.',
                'reset_terminal' => true,
            ]);
        }

        $request->validate([
            'pin' => ['required', 'digits:4'],
        ]);

        $terminal = PosTerminal::with(['restaurant', 'branch'])
            ->where('id', Session::get('staff_terminal_id'))
            ->where('is_active', true)
            ->first();

        if (! $terminal) {
            Session::forget([
                'staff_terminal_id',
                'staff_terminal_code',
                'staff_restaurant_id',
                'staff_restaurant_name',
                'staff_branch_id',
                'staff_branch_name',
                'staff_user_id',
                'staff_user_name',
                'staff_user_role',
                'staff_user_branch_id',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terminal sessiyası tapılmadı və ya deaktiv edilib.',
                'reset_terminal' => true,
            ]);
        }

        $query = User::where('restaurant_id', $terminal->restaurant_id)
            ->where('login_type', 'pos')
            ->where('staff_code', $request->pin)
            ->where('is_active', true);

        if ($terminal->branch_id) {
            $query->where('branch_id', $terminal->branch_id);
        } else {
            $query->whereNull('branch_id');
        }

        $user = $query->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'PIN kod düzgün deyil və ya bu terminal üçün icazəniz yoxdur.',
            ]);
        }

        Session::put([
            'staff_terminal_id' => $terminal->id,
            'staff_terminal_code' => $terminal->activation_code,

            'staff_restaurant_id' => $terminal->restaurant_id,
            'staff_restaurant_name' => $terminal->restaurant->name ?? 'Restoran',

            'staff_branch_id' => $terminal->branch_id,
            'staff_branch_name' => $terminal->branch
                ? $terminal->branch->name
                : 'Ümumi restoran',

            'staff_user_id' => $user->id,
            'staff_user_name' => $user->name,
            'staff_user_role' => $user->role,
            'staff_user_branch_id' => $user->branch_id,
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('staff.dashboard'),
        ]);
    }

    public function dashboard(Request $request)
    {
        if (! Session::has('staff_terminal_id') || ! Session::has('staff_user_id')) {
            return redirect()->route('staff.login');
        }

        $restaurantId = Session::get('staff_restaurant_id');
        $branchId = Session::get('staff_branch_id');

        $categories = MenuCategory::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::with('menuCategory')
            ->where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->where('show_in_terminal', true)
            ->where('is_hidden', false)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereNull('branch_id')
                        ->orWhere('branch_id', $branchId);
                });
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('menu_category_id', $request->category_id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $areas = DiningArea::with([
            'tables' => function ($query) {
                $query->with([
                    'openOrder.staff',
                    'activeReservation',
                    'nextReservation',
                    'todayReservations',
                ]);
            }
        ])
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereNull('branch_id')
                        ->orWhere('branch_id', $branchId);
                });
            })
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('staff_auth.dashboard', compact(
            'categories',
            'products',
            'areas'
        ));
    }

    public function logout()
    {
        Session::forget([
            'staff_user_id',
            'staff_user_name',
            'staff_user_role',
            'staff_user_branch_id',
        ]);

        return redirect()->route('staff.login');
    }

    public function resetTerminal()
    {
        Session::forget([
            'staff_terminal_id',
            'staff_terminal_code',

            'staff_restaurant_id',
            'staff_restaurant_name',

            'staff_branch_id',
            'staff_branch_name',

            'staff_user_id',
            'staff_user_name',
            'staff_user_role',
            'staff_user_branch_id',
        ]);

        return redirect()->route('staff.login');
    }
}
