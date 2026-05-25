<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuDepartment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        $products = Product::with(['menuCategory', 'menuDepartment', 'branch'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.menu.products.index', compact('products'));
    }

    public function create()
    {
        $restaurantId = Session::get('owner_restaurant_id');

        $categories = MenuCategory::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $departments = MenuDepartment::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('owner.menu.products.create', compact(
            'categories',
            'departments'
        ));
    }

    public function store(Request $request)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:255'],
            'menu_category_id' => ['nullable', 'exists:menu_categories,id'],
            'menu_department_id' => ['nullable', 'exists:menu_departments,id'],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:30'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'show_in_qr_menu' => ['nullable', 'boolean'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                'products',
                'public'
            );
        }

        Product::create([
            'restaurant_id' => $restaurantId,
            'branch_id' => null,

            'menu_category_id' => $request->menu_category_id,
            'menu_department_id' => $request->menu_department_id,

            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'barcode' => $request->barcode,
            'description' => $request->description,

            'image' => $imagePath,
            'color' => $request->color,

            'cost_price' => $request->cost_price ?? 0,
            'sale_price' => $request->sale_price,

            'is_hidden' => $request->boolean('is_hidden'),
            'is_gift' => $request->boolean('is_gift'),
            'allow_discount' => ! $request->boolean('disable_discount'),
            'sold_by_weight' => $request->boolean('sold_by_weight'),
            'show_in_terminal' => ! $request->boolean('is_hidden'),

            /*
            |--------------------------------------------------
            | QR Menu / eMenu seçimləri
            |--------------------------------------------------
            */

            'show_in_qr_menu' => $request->boolean('show_in_qr_menu'),

            'sort_order' => 0,
            'is_active' => true,
        ]);

        return redirect()
            ->route('owner.menu.products.index')
            ->with('success', 'Məhsul uğurla yaradıldı.');
    }

    public function edit(Product $product)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        abort_if(! $restaurantId || (int) $product->restaurant_id !== (int) $restaurantId, 403);

        $categories = MenuCategory::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $departments = MenuDepartment::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('owner.menu.products.edit', compact(
            'product',
            'categories',
            'departments'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $restaurantId = Session::get('owner_restaurant_id');

        abort_if(! $restaurantId || (int) $product->restaurant_id !== (int) $restaurantId, 403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:255'],
            'menu_category_id' => ['nullable', 'exists:menu_categories,id'],
            'menu_department_id' => ['nullable', 'exists:menu_departments,id'],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:30'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'show_in_qr_menu' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store(
                'products',
                'public'
            );
        }

        $product->update([
            'menu_category_id' => $request->menu_category_id,
            'menu_department_id' => $request->menu_department_id,

            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'barcode' => $request->barcode,
            'description' => $request->description,

            'image' => $imagePath,
            'color' => $request->color,

            'cost_price' => $request->cost_price ?? 0,
            'sale_price' => $request->sale_price,

            'is_hidden' => $request->boolean('is_hidden'),
            'is_gift' => $request->boolean('is_gift'),
            'allow_discount' => ! $request->boolean('disable_discount'),
            'sold_by_weight' => $request->boolean('sold_by_weight'),
            'show_in_terminal' => ! $request->boolean('is_hidden'),

            /*
            |--------------------------------------------------
            | QR Menu / eMenu seçimləri
            |--------------------------------------------------
            */

            'show_in_qr_menu' => $request->boolean('show_in_qr_menu'),

            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('owner.menu.products.index')
            ->with('success', 'Məhsul uğurla yeniləndi.');
    }
}
