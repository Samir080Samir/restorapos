<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Kateqoriyaların siyahısı.
     */
    public function index()
    {
        $categories = Category::with('restaurant')->latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Yeni kateqoriya əlavə etmə səhifəsi.
     */
    public function create()
    {
        $restaurants = Restaurant::where('status', 'active')->get();

        return view('admin.categories.create', compact('restaurants'));
    }

    /**
     * Yeni kateqoriyanı bazaya əlavə edir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        Category::create([
            'restaurant_id' => $request->restaurant_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kateqoriya uğurla əlavə edildi.');
    }
}
