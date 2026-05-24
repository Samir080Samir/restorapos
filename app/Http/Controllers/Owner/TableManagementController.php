<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\DiningArea;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TableManagementController extends Controller
{
    private int $gridSize = 24;

    public function index()
    {
        $areas = $this->getAreas();

        if ($areas === null) {
            return redirect()->route('owner.login');
        }

        return view('owner.tables.manage', compact('areas'));
    }

    public function tablesIndex()
    {
        $areas = $this->getAreas();

        if ($areas === null) {
            return redirect()->route('owner.login');
        }

        return view('owner.tables.index', compact('areas'));
    }

    public function storeArea(Request $request)
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        DiningArea::create([
            'restaurant_id' => $restaurantId,
            'branch_id' => $this->branchId(),
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Zal yaradıldı.');
    }

    public function storeTable(Request $request)
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dining_area_id' => ['nullable', 'exists:dining_areas,id'],
            'shape' => ['required', 'in:square,circle,rectangle'],
            'seats' => ['nullable', 'integer', 'min:1', 'max:50'],
            'show_seats' => ['nullable', 'boolean'],
        ]);

        $size = $this->tableSize($validated['shape']);

        RestaurantTable::create([
            'restaurant_id' => $restaurantId,
            'branch_id' => $this->branchId(),
            'dining_area_id' => $validated['dining_area_id'] ?? null,
            'name' => $validated['name'],
            'code' => strtoupper(Str::random(5)),
            'shape' => $validated['shape'],
            'seats' => $validated['seats'] ?? 4,
            'show_seats' => $request->boolean('show_seats'),
            'position_x' => $this->gridSize,
            'position_y' => $this->gridSize,
            'width' => $size['width'],
            'height' => $size['height'],
            'status' => 'empty',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Masa əlavə edildi.');
    }

    public function updateTable(Request $request, RestaurantTable $table)
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        if ((int) $table->restaurant_id !== (int) $restaurantId) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dining_area_id' => ['nullable', 'exists:dining_areas,id'],
            'shape' => ['required', 'in:square,circle,rectangle'],
            'seats' => ['nullable', 'integer', 'min:1', 'max:50'],
            'show_seats' => ['nullable', 'boolean'],
        ]);

        $size = $this->tableSize($validated['shape']);

        $table->update([
            'dining_area_id' => $validated['dining_area_id'] ?? null,
            'name' => $validated['name'],
            'shape' => $validated['shape'],
            'seats' => $validated['seats'] ?? 4,
            'show_seats' => $request->boolean('show_seats'),
            'width' => $size['width'],
            'height' => $size['height'],
        ]);

        return back()->with('success', 'Masa yeniləndi.');
    }

    public function saveLayout(Request $request)
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'Sessiya bitib.',
            ], 401);
        }

        $tables = $request->input('tables', []);

        foreach ($tables as $item) {
            $table = RestaurantTable::where('restaurant_id', $restaurantId)
                ->where('id', $item['id'] ?? null)
                ->first();

            if (! $table) {
                continue;
            }

            $table->update([
                'position_x' => $this->snap((int) ($item['x'] ?? 0)),
                'position_y' => $this->snap((int) ($item['y'] ?? 0)),
                'width' => $this->snap((int) ($item['width'] ?? $table->width)),
                'height' => $this->snap((int) ($item['height'] ?? $table->height)),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroyTable(RestaurantTable $table)
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        if ((int) $table->restaurant_id !== (int) $restaurantId) {
            abort(403);
        }

        $table->delete();

        return back()->with('success', 'Masa silindi.');
    }
    public function sortAreas(Request $request)
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        foreach ($request->input('areas', []) as $areaId => $sortOrder) {

            DiningArea::where('restaurant_id', $restaurantId)
                ->where('id', $areaId)
                ->update([
                    'sort_order' => (int) $sortOrder,
                ]);
        }

        return back()->with('success', 'Zal sıralaması yeniləndi.');
    }

    private function getAreas()
    {
        $restaurantId = $this->restaurantId();

        if (! $restaurantId) {
            return null;
        }

        $branchId = $this->branchId();

        return DiningArea::with(['tables'])
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
    }

    private function restaurantId(): ?int
    {
        return Session::get('owner_restaurant_id');
    }

    private function branchId(): ?int
    {
        return Session::get('owner_selected_branch_id')
            ?: Session::get('owner_branch_id');
    }

    private function tableSize(string $shape): array
    {
        if ($shape === 'rectangle') {
            return [
                'width' => $this->gridSize * 6,
                'height' => $this->gridSize * 4,
            ];
        }

        return [
            'width' => $this->gridSize * 4,
            'height' => $this->gridSize * 4,
        ];
    }

    private function snap(int $value): int
    {
        return (int) round($value / $this->gridSize) * $this->gridSize;
    }
}
