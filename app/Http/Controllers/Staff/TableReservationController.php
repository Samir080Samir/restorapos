<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use App\Models\TableReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableReservationController extends Controller
{
    public function store(Request $request)
    {
        $role = session('staff_user_role');

        if (! in_array($role, ['cashier'])) {
            return response()->json([
                'success' => false,
                'message' => 'Rezerv yaratmaq icazəniz yoxdur.',
            ], 403);
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

        return DB::transaction(function () use ($request) {
            $table = RestaurantTable::lockForUpdate()->findOrFail($request->table_id);

            $estimatedEndTime = Carbon::parse(
                $request->reservation_date . ' ' . $request->start_time
            )->addHours(2)->format('H:i');

            $hasConflict = TableReservation::hasConflict(
                $table->id,
                $request->reservation_date,
                $request->start_time,
                $estimatedEndTime
            );

            if ($hasConflict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu masa seçilən saat aralığında artıq rezerv edilib.',
                ], 422);
            }

            $reservation = TableReservation::create([
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
                'created_by' => session('staff_user_id'),
            ]);

            $table->refreshOperationalStatus();

            return response()->json([
                'success' => true,
                'message' => 'Rezerv yaradıldı.',
                'reservation' => $reservation,
                'table_status' => $table->fresh()->status,
            ]);
        });
    }

    public function cancel($id)
    {
        $role = session('staff_user_role');

        if (! in_array($role, ['cashier'])) {
            return response()->json([
                'success' => false,
                'message' => 'Rezerv ləğv etmək icazəniz yoxdur.',
            ], 403);
        }

        return DB::transaction(function () use ($id) {
            $reservation = TableReservation::lockForUpdate()->findOrFail($id);

            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            $table = RestaurantTable::lockForUpdate()->find($reservation->table_id);
            if ($table) {
                $table->refreshOperationalStatus();
            }

            return response()->json([
                'success' => true,
                'message' => 'Rezerv ləğv edildi.',
                'table_status' => $table?->fresh()?->status,
            ]);
        });
    }

    public function complete($id)
    {
        $role = session('staff_user_role');

        if (! in_array($role, ['cashier'])) {
            return response()->json([
                'success' => false,
                'message' => 'Rezerv tamamlamaq icazəniz yoxdur.',
            ], 403);
        }

        return DB::transaction(function () use ($id) {
            $reservation = TableReservation::lockForUpdate()->findOrFail($id);

            $reservation->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $table = RestaurantTable::lockForUpdate()->find($reservation->table_id);
            if ($table) {
                $table->refreshOperationalStatus();
            }

            return response()->json([
                'success' => true,
                'message' => 'Rezerv tamamlandı.',
                'table_status' => $table?->fresh()?->status,
            ]);
        });
    }
}
