<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    /**
     * Kateqoriyalar siyahısı
     */
    public function index()
    {
        $restaurantId = session('owner_restaurant_id');

        $categories = MenuCategory::where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.menu.categories.index', compact('categories'));
    }

    /**
     * Kateqoriya yarat səhifəsi
     */
    public function create()
    {
        return view('owner.menu.categories.create');
    }

    /**
     * Yeni kateqoriya əlavə et
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ]);

        MenuCategory::create([
            'restaurant_id' => session('owner_restaurant_id'),

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'icon' => $request->icon,

            'color' => $request->color ?? '#4f46e5',

            'sort_order' => $request->sort_order ?? 0,

            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('owner.menu.categories.index')
            ->with('success', 'Kateqoriya uğurla yaradıldı.');
    }

    /**
     * Kateqoriya edit səhifəsi
     */
    public function edit(MenuCategory $category)
    {
        if ($category->restaurant_id != session('owner_restaurant_id')) {
            abort(403);
        }

        return view('owner.menu.categories.edit', compact('category'));
    }

    /**
     * Kateqoriya yenilə
     */
    public function update(Request $request, MenuCategory $category)
    {
        if ($category->restaurant_id != session('owner_restaurant_id')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ]);

        $category->update([
            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'icon' => $request->icon,

            'color' => $request->color ?? '#4f46e5',

            'sort_order' => $request->sort_order ?? 0,

            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('owner.menu.categories.index')
            ->with('success', 'Kateqoriya yeniləndi.');
    }

    /**
     * Kateqoriya sil
     */
    public function destroy(MenuCategory $category)
    {
        if ($category->restaurant_id != session('owner_restaurant_id')) {
            abort(403);
        }

        $category->delete();

        return redirect()
            ->route('owner.menu.categories.index')
            ->with('success', 'Kateqoriya silindi.');
    }
}
