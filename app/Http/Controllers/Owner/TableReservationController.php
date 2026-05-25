<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use App\Models\TableReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('reservation_date')
            ->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();

        $statsQuery = (clone $baseQuery)->whereDate('reservation_date', $selectedDate);

        $stats = [
            'active' => (clone $statsQuery)->whereIn('status', ['reserved', 'arrived'])->count(),
            'total' => (clone $statsQuery)->count(),
            'completed' => (clone $statsQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
        ];

        return view('owner.reservations.index', compact('reservations', 'stats', 'selectedDate', 'status'));
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

        return DB::transaction(function () use ($request, $restaurantId, $branchId) {
            $table = RestaurantTable::where('restaurant_id', $restaurantId)
                ->where('id', $request->table_id)
                ->when($branchId, function ($query) use ($branchId) {
                    $query->where(function ($q) use ($branchId) {
                        $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                    });
                })
                ->lockForUpdate()
                ->firstOrFail();

            $estimatedEndTime = Carbon::parse(
                $request->reservation_date . ' ' . $request->start_time
            )->addHours(2)->format('H:i');

            if (TableReservation::hasConflict($table->id, $request->reservation_date, $request->start_time, $estimatedEndTime)) {
                return back()->withInput()->with('error', 'Bu masa seçilən saat aralığında artıq rezerv edilib.');
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
                'estimated_end_time' => $estimatedEndTime,
                'status' => 'reserved',
                'note' => $request->note,
                'created_by' => session('owner_user_id'),
            ]);

            $table->refreshOperationalStatus();

            return redirect()
                ->route('owner.reservations.index', ['date' => $request->reservation_date])
                ->with('success', 'Rezerv yaradıldı.');
        });
    }

    public function cancel($id)
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        return DB::transaction(function () use ($id, $restaurantId) {
            $reservation = TableReservation::where('restaurant_id', $restaurantId)
                ->where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            $table = RestaurantTable::lockForUpdate()->find($reservation->table_id);
            if ($table) {
                $table->refreshOperationalStatus();
            }

            return back()->with('success', 'Rezerv ləğv edildi.');
        });
    }

    public function complete($id)
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        return DB::transaction(function () use ($id, $restaurantId) {
            $reservation = TableReservation::where('restaurant_id', $restaurantId)
                ->where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $reservation->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $table = RestaurantTable::lockForUpdate()->find($reservation->table_id);
            if ($table) {
                $table->refreshOperationalStatus();
            }

            return back()->with('success', 'Rezerv tamamlandı.');
        });
    }
}
