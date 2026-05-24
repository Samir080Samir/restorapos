<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\OwnerRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class OwnerStaffController extends Controller
{
    public function index()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $users = User::with(['branch', 'ownerRoles'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.staff.index', compact('users'));
    }

    public function create()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $branches = Branch::where('restaurant_id', $restaurantId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $roles = OwnerRole::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('owner.staff.create', compact('branches', 'roles'));
    }

    public function store(Request $request)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $role = OwnerRole::where('restaurant_id', $restaurantId)
            ->findOrFail($request->owner_role_id);

        $codeRule = $role->login_type === 'pos'
            ? ['required', 'digits:4', 'unique:users,staff_code']
            : ['required', 'regex:/^[A-Za-z0-9@#$%*!_-]{8}$/', 'unique:users,staff_code'];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')->where('restaurant_id', $restaurantId),
            ],

            'owner_role_id' => [
                'required',
                Rule::exists('owner_roles', 'id')->where('restaurant_id', $restaurantId),
            ],

            'staff_code' => $codeRule,

            'system_role' => [
                'required',
                Rule::in([
                    'administrator',
                    'cashier',
                    'waiter',
                    'kitchen',
                    'finance',
                    'branch_manager',
                    'warehouse_manager',
                    'staff',
                ]),
            ],
        ]);

        $email = $request->email
            ?: 'staff_' . $restaurantId . '_' . time() . '_' . rand(1000, 9999) . '@novapos.local';

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->staff_code),
            'restaurant_id' => $restaurantId,
            'branch_id' => $request->branch_id ?: null,
            'role' => $request->system_role,
            'login_type' => $role->login_type,
            'staff_code' => $request->staff_code,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $user->ownerRoles()->sync([$role->id]);

        return redirect()
            ->route('owner.staff.users.index')
            ->with('success', 'Əməkdaş uğurla yaradıldı.');
    }

    public function edit(User $user)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || $user->restaurant_id != $restaurantId) {
            abort(403);
        }

        $branches = Branch::where('restaurant_id', $restaurantId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $roles = OwnerRole::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedRoleId = $user->ownerRoles()
            ->pluck('owner_roles.id')
            ->first();

        return view('owner.staff.edit', compact(
            'user',
            'branches',
            'roles',
            'selectedRoleId'
        ));
    }

    public function update(Request $request, User $user)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || $user->restaurant_id != $restaurantId) {
            abort(403);
        }

        $role = OwnerRole::where('restaurant_id', $restaurantId)
            ->findOrFail($request->owner_role_id);

        $codeRule = $role->login_type === 'pos'
            ? [
                'nullable',
                'digits:4',
                Rule::unique('users', 'staff_code')->ignore($user->id),
            ]
            : [
                'nullable',
                'regex:/^[A-Za-z0-9@#$%*!_-]{8}$/',
                Rule::unique('users', 'staff_code')->ignore($user->id),
            ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')->where('restaurant_id', $restaurantId),
            ],

            'owner_role_id' => [
                'required',
                Rule::exists('owner_roles', 'id')->where('restaurant_id', $restaurantId),
            ],

            'staff_code' => $codeRule,

            'system_role' => [
                'required',
                Rule::in([
                    'administrator',
                    'cashier',
                    'waiter',
                    'kitchen',
                    'finance',
                    'branch_manager',
                    'warehouse_manager',
                    'staff',
                ]),
            ],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email ?: $user->email,
            'branch_id' => $request->branch_id ?: null,
            'role' => $request->system_role,
            'login_type' => $role->login_type,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('staff_code')) {
            $data['staff_code'] = $request->staff_code;
            $data['password'] = Hash::make($request->staff_code);
        }

        $user->update($data);

        $user->ownerRoles()->sync([$role->id]);

        return redirect()
            ->route('owner.staff.users.index')
            ->with('success', 'Əməkdaş uğurla yeniləndi.');
    }
}
