<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\MenuDepartment;
use Illuminate\Http\Request;

class MenuDepartmentController extends Controller
{
    /**
     * Şöbələrin siyahısı
     */
    public function index()
    {
        $restaurantId = session('owner_restaurant_id');

        $departments = MenuDepartment::where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.menu.departments.index', compact('departments'));
    }

    /**
     * Şöbə yarat səhifəsi
     */
    public function create()
    {
        return view('owner.menu.departments.create');
    }

    /**
     * Yeni şöbə əlavə et
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable'],
        ]);

        MenuDepartment::create([
            'restaurant_id' => session('owner_restaurant_id'),
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#334155',
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('owner.menu.departments.index')
            ->with('success', 'Şöbə uğurla yaradıldı.');
    }

    /**
     * Şöbə edit səhifəsi
     */
    public function edit(MenuDepartment $department)
    {
        if ($department->restaurant_id != session('owner_restaurant_id')) {
            abort(403);
        }

        return view('owner.menu.departments.edit', compact('department'));
    }

    /**
     * Şöbə yenilə
     */
    public function update(Request $request, MenuDepartment $department)
    {
        if ($department->restaurant_id != session('owner_restaurant_id')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable'],
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#334155',
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('owner.menu.departments.index')
            ->with('success', 'Şöbə məlumatları yeniləndi.');
    }

    /**
     * Şöbə sil
     */
    public function destroy(MenuDepartment $department)
    {
        if ($department->restaurant_id != session('owner_restaurant_id')) {
            abort(403);
        }

        $department->delete();

        return redirect()
            ->route('owner.menu.departments.index')
            ->with('success', 'Şöbə silindi.');
    }
}
