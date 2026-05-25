<?php

namespace App\Models;

use Carbon\Carbon;
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

    public const BUSINESS_TIMEZONE = 'Asia/Baku';

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

    public static function businessNow(): Carbon
    {
        return Carbon::now(self::BUSINESS_TIMEZONE);
    }

    public static function businessToday(): string
    {
        return self::businessNow()->toDateString();
    }

    public function activeReservation()
    {
        return $this->hasOne(TableReservation::class, 'table_id')
            ->whereDate('reservation_date', self::businessToday())
            ->whereIn('status', ['reserved', 'arrived'])
            ->orderByRaw("CASE WHEN status = 'arrived' THEN 0 ELSE 1 END")
            ->orderBy('start_time');
    }

    public function nextReservation()
    {
        return $this->hasOne(TableReservation::class, 'table_id')
            ->whereDate('reservation_date', self::businessToday())
            ->whereIn('status', ['reserved', 'arrived'])
            ->whereTime('start_time', '>=', self::businessNow()->copy()->subMinutes(15)->format('H:i:s'))
            ->orderByRaw("CASE WHEN status = 'arrived' THEN 0 ELSE 1 END")
            ->orderBy('start_time');
    }

    public function todayReservations()
    {
        return $this->hasMany(TableReservation::class, 'table_id')
            ->whereDate('reservation_date', self::businessToday())
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

    /**
     * POS ekranında göstəriləcək real rezerv.
     * Köhnə/stale relationship cache istifadə etmir; hər dəfə DB-dən təzə oxuyur.
     */
    public function visibleReservation(): ?TableReservation
    {
        $reservations = TableReservation::query()
            ->where('table_id', $this->id)
            ->whereDate('reservation_date', self::businessToday())
            ->whereIn('status', ['reserved', 'arrived'])
            ->orderByRaw("CASE WHEN status = 'arrived' THEN 0 ELSE 1 END")
            ->orderBy('start_time')
            ->get();

        if ($reservations->isEmpty()) {
            return null;
        }

        $arrived = $reservations->first(function (TableReservation $reservation) {
            return $reservation->isArrived();
        });

        if ($arrived) {
            return $arrived;
        }

        $activeWindow = $reservations->first(function (TableReservation $reservation) {
            return $reservation->isDueSoon(15) || $reservation->isLate(15);
        });

        if ($activeWindow) {
            return $activeWindow;
        }

        $upcoming = $reservations->first(function (TableReservation $reservation) {
            return $reservation->isUpcoming();
        });

        return $upcoming ?: $reservations->first();
    }

    public function refreshOperationalStatus(): void
    {
        if ($this->openOrders()->exists()) {
            if (! in_array($this->status, ['busy', 'waiting_payment'], true)) {
                $this->update(['status' => 'busy']);
            }

            return;
        }

        if ($this->todayReservations()->exists()) {
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
        if ($this->isWaitingPayment() && $this->openOrders()->exists()) {
            return 'waiting_payment';
        }

        if ($this->openOrders()->exists()) {
            return 'busy';
        }

        $reservation = $this->visibleReservation();

        if (! $reservation) {
            return 'empty';
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
            'reservation_due_soon' => '15 dəq. qalıb',
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
