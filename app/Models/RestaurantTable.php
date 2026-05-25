<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'dining_area_id',
        'name',
        'code',
        'shape',
        'seats',
        'show_seats',
        'position_x',
        'position_y',
        'width',
        'height',
        'status',
        'sort_order',
        'is_active',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function diningArea()
    {
        return $this->belongsTo(DiningArea::class);
    }

    public function openOrder()
    {
        return $this->hasOne(PosOrder::class, 'table_id')
            ->where('status', 'open')
            ->oldestOfMany('opened_at');
    }

    public function openOrders()
    {
        return $this->hasMany(PosOrder::class, 'table_id')
            ->where('status', 'open')
            ->orderBy('opened_at');
    }

    public function reservations()
    {
        return $this->hasMany(TableReservation::class, 'table_id');
    }

    public function activeReservation()
    {
        return $this->hasOne(TableReservation::class, 'table_id')
            ->whereDate('reservation_date', now()->toDateString())
            ->whereIn('status', ['reserved', 'arrived'])
            ->orderByRaw("CASE WHEN status = 'arrived' THEN 0 ELSE 1 END")
            ->orderBy('start_time');
    }

    public function nextReservation()
    {
        return $this->hasOne(TableReservation::class, 'table_id')
            ->whereDate('reservation_date', now()->toDateString())
            ->whereIn('status', ['reserved', 'arrived'])
            ->whereTime('start_time', '>=', now()->subMinutes(15)->format('H:i:s'))
            ->orderByRaw("CASE WHEN status = 'arrived' THEN 0 ELSE 1 END")
            ->orderBy('start_time');
    }

    public function todayReservations()
    {
        return $this->hasMany(TableReservation::class, 'table_id')
            ->whereDate('reservation_date', now()->toDateString())
            ->whereIn('status', ['reserved', 'arrived'])
            ->orderBy('start_time');
    }

    public function isEmpty()
    {
        return $this->status === 'empty';
    }

    public function isBusy()
    {
        return $this->status === 'busy';
    }

    public function isReserved()
    {
        return $this->status === 'reserved';
    }

    public function isWaitingPayment()
    {
        return $this->status === 'waiting_payment';
    }

    public function refreshOperationalStatus(): void
    {
        if ($this->openOrders()->exists()) {
            if (! in_array($this->status, ['busy', 'waiting_payment'], true)) {
                $this->update(['status' => 'busy']);
            }

            return;
        }

        if ($this->todayReservations()->whereIn('status', ['reserved', 'arrived'])->exists()) {
            if ($this->status !== 'reserved') {
                $this->update(['status' => 'reserved']);
            }

            return;
        }

        if ($this->status !== 'empty') {
            $this->update(['status' => 'empty']);
        }
    }

    public function reservationState()
    {
        if ($this->isBusy()) {
            return 'busy';
        }

        if ($this->isWaitingPayment()) {
            return 'waiting_payment';
        }

        $reservation = $this->activeReservation()->first()
            ?: $this->nextReservation()->first();

        if (! $reservation) {
            return $this->status === 'reserved' ? 'empty' : ($this->status ?: 'empty');
        }

        if ($reservation->isArrived()) {
            return 'reservation_arrived';
        }

        if ($reservation->isLate(15)) {
            return 'reservation_late';
        }

        if ($reservation->isDueSoon(15)) {
            return 'reservation_due_soon';
        }

        if ($reservation->isUpcoming()) {
            return 'reservation_upcoming';
        }

        return 'reserved';
    }

    public function reservationStateLabel()
    {
        return match ($this->reservationState()) {
            'busy' => 'Dolu',
            'waiting_payment' => 'Hesab gözləyir',
            'reservation_late' => 'Rezerv gecikir',
            'reservation_due_soon' => 'Rezerv yaxınlaşır',
            'reservation_upcoming' => 'Rezerv var',
            'reservation_arrived' => 'Müştəri gəlib',
            'reserved' => 'Rezerv',
            default => 'Boş',
        };
    }

    public function reservationBadgeClass()
    {
        return match ($this->reservationState()) {
            'busy' => 'status-busy',
            'waiting_payment' => 'status-waiting',
            'reservation_late' => 'status-busy',
            'reservation_due_soon' => 'status-waiting',
            'reservation_upcoming' => 'status-reserved',
            'reservation_arrived' => 'status-reserved',
            'reserved' => 'status-reserved',
            default => 'status-empty',
        };
    }
}
