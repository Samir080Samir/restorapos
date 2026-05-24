<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use App\Models\TableReservation;
use Illuminate\Http\Request;

class TableReservationController extends Controller
{
    public function index(Request $request)
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $selectedDate = $request->filled('date') ? $request->date : now()->toDateString();
        $status = $request->status;

        $baseQuery = TableReservation::with(['table', 'branch', 'creator'])
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                });
            });

        $reservations = (clone $baseQuery)
            ->whereDate('reservation_date', $selectedDate)
            ->when($status, fn($query) => $query->where('status', $status))
            ->orderBy('reservation_date')
            ->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();

        $statsQuery = (clone $baseQuery)->whereDate('reservation_date', $selectedDate);

        $stats = [
            'active' => (clone $statsQuery)->where('status', 'reserved')->count(),
            'total' => (clone $statsQuery)->count(),
            'completed' => (clone $statsQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
        ];

        return view('owner.reservations.index', compact(
            'reservations',
            'stats',
            'selectedDate',
            'status'
        ));
    }

    public function create()
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $tables = RestaurantTable::with('diningArea')
            ->where('restaurant_id', $restaurantId)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                });
            })
            ->where('is_active', true)
            ->orderBy('dining_area_id')
            ->orderBy('name')
            ->get();

        return view('owner.reservations.create', compact('tables'));
    }

    public function store(Request $request)
    {
        $restaurantId = session('owner_restaurant_id');
        $branchId = session('owner_selected_branch_id') ?: session('owner_branch_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $request->validate([
            'table_id' => ['required', 'exists:restaurant_tables,id'],
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'reservation_date' => ['required', 'date'],
            'start_time' => ['required'],
            'note' => ['nullable', 'string'],
        ]);

        $table = RestaurantTable::where('restaurant_id', $restaurantId)
            ->where('id', $request->table_id)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                });
            })
            ->firstOrFail();

        $exists = TableReservation::where('table_id', $table->id)
            ->whereDate('reservation_date', $request->reservation_date)
            ->where('start_time', $request->start_time)
            ->where('status', 'reserved')
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Bu masa həmin saat üçün artıq rezerv edilib.');
        }

        TableReservation::create([
            'restaurant_id' => $table->restaurant_id,
            'branch_id' => $table->branch_id,
            'table_id' => $table->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'guest_count' => $request->guest_count ?: 1,
            'reservation_date' => $request->reservation_date,
            'start_time' => $request->start_time,
            'status' => 'reserved',
            'note' => $request->note,
            'created_by' => session('owner_user_id'),
        ]);

        return redirect()
            ->route('owner.reservations.index', ['date' => $request->reservation_date])
            ->with('success', 'Rezerv yaradıldı.');
    }

    public function cancel($id)
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $reservation = TableReservation::where('restaurant_id', $restaurantId)
            ->where('id', $id)
            ->firstOrFail();

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Rezerv ləğv edildi.');
    }

    public function complete($id)
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $reservation = TableReservation::where('restaurant_id', $restaurantId)
            ->where('id', $id)
            ->firstOrFail();

        $reservation->update(['status' => 'completed']);

        return back()->with('success', 'Rezerv tamamlandı.');
    }
}
