<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Permission;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * İstifadəçilərin siyahısı.
     */
    public function index()
    {
        $users = User::with(['restaurant', 'branch', 'permissions'])
            ->latest()
            ->get();

        $totalUsers = User::count();

        $activeUsers = User::whereNotNull('email')->count();

        $restaurantAdmins = User::where('role', 'restaurant_admin')->count();

        $staffUsers = User::whereIn('role', [
            'restaurant_manager',
            'branch_manager',
            'cashier',
            'waiter',
            'kitchen',
        ])->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'restaurantAdmins',
            'staffUsers'
        ));
    }

    /**
     * Yeni istifadəçi əlavə etmə səhifəsi.
     */
    public function create()
    {
        $restaurants = Restaurant::where('status', 'active')->get();

        $branches = Branch::with('restaurant')
            ->where('status', 'active')
            ->get();

        $permissions = Permission::orderBy('group')
            ->orderBy('name')
            ->get();

        return view('admin.users.create', compact(
            'restaurants',
            'branches',
            'permissions'
        ));
    }

    /**
     * Yeni istifadəçini bazaya əlavə edir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => 'required|string|min:6',

            'restaurant_id' => 'nullable|exists:restaurants,id',

            'branch_id' => 'nullable|exists:branches,id',

            'role' => 'required|string',

            'permissions' => 'nullable|array',

            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'restaurant_id' => $request->restaurant_id,
            'branch_id' => $request->branch_id,
            'role' => $request->role,
        ]);

        $user->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'İstifadəçi uğurla əlavə edildi.');
    }

    /**
     * İstifadəçi redaktə səhifəsi.
     */
    public function edit(User $user)
    {
        $restaurants = Restaurant::where('status', 'active')->get();

        $branches = Branch::with('restaurant')
            ->where('status', 'active')
            ->get();

        $permissions = Permission::orderBy('group')
            ->orderBy('name')
            ->get();

        return view('admin.users.edit', compact(
            'user',
            'restaurants',
            'branches',
            'permissions'
        ));
    }

    /**
     * İstifadəçi məlumatlarını yeniləyir.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => 'nullable|string|min:6',

            'restaurant_id' => 'nullable|exists:restaurants,id',

            'branch_id' => 'nullable|exists:branches,id',

            'role' => 'required|string',

            'permissions' => 'nullable|array',

            'permissions.*' => 'exists:permissions,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,

            'restaurant_id' => $request->restaurant_id,
            'branch_id' => $request->branch_id,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'İstifadəçi məlumatları yeniləndi.');
    }

    /**
     * İstifadəçini silir.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->back()
                ->with('success', 'Öz istifadəçinizi silə bilməzsiniz.');
        }

        $user->permissions()->detach();

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'İstifadəçi silindi.');
    }
}
