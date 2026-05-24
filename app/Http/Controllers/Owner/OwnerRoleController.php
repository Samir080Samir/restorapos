<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OwnerPermission;
use App\Models\OwnerRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OwnerRoleController extends Controller
{
    public function index()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $roles = OwnerRole::withCount('permissions')
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.roles.index', compact('roles'));
    }

    public function create()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $permissions = OwnerPermission::orderBy('type')
            ->orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy(['type', 'group']);

        return view('owner.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login_type' => ['required', Rule::in(['panel', 'pos'])],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:owner_permissions,id'],
        ]);

        $role = OwnerRole::create([
            'restaurant_id' => $restaurantId,
            'login_type' => $request->login_type,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $restaurantId,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('owner.staff.roles.index')
            ->with('success', 'Vəzifə uğurla yaradıldı.');
    }

    public function edit(OwnerRole $role)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || $role->restaurant_id != $restaurantId) {
            abort(403);
        }

        $permissions = OwnerPermission::orderBy('type')
            ->orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy(['type', 'group']);

        $selectedPermissions = $role->permissions()
            ->pluck('owner_permissions.id')
            ->toArray();

        return view('owner.roles.edit', compact(
            'role',
            'permissions',
            'selectedPermissions'
        ));
    }

    public function update(Request $request, OwnerRole $role)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        if (! $restaurantId || $role->restaurant_id != $restaurantId) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login_type' => ['required', Rule::in(['panel', 'pos'])],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:owner_permissions,id'],
        ]);

        $role->update([
            'name' => $request->name,
            'login_type' => $request->login_type,
            'slug' => Str::slug($request->name) . '-' . $restaurantId,
            'is_active' => $request->boolean('is_active'),
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('owner.staff.roles.index')
            ->with('success', 'Vəzifə uğurla yeniləndi.');
    }
}