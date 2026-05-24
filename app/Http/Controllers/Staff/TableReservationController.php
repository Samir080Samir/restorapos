<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use App\Models\TableReservation;
use Illuminate\Http\Request;

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

        $table = RestaurantTable::findOrFail($request->table_id);

        $exists = TableReservation::where('table_id', $table->id)
            ->whereDate('reservation_date', $request->reservation_date)
            ->where('start_time', $request->start_time)
            ->where('status', 'reserved')
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Bu saat üçün artıq rezerv var.',
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
            'status' => 'reserved',
            'note' => $request->note,
            'created_by' => session('staff_user_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rezerv yaradıldı.',
            'reservation' => $reservation,
        ]);
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

        $reservation = TableReservation::findOrFail($id);
        $reservation->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Rezerv ləğv edildi.',
        ]);
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

        $reservation = TableReservation::findOrFail($id);
        $reservation->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Rezerv tamamlandı.',
        ]);
    }
}
