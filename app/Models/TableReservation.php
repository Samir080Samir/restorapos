<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    public const BUSINESS_TIMEZONE = 'Asia/Baku';
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'table_id',
        'customer_name',
        'customer_phone',
        'guest_count',
        'reservation_date',
        'start_time',
        'estimated_end_time',
        'end_time',
        'status',
        'arrived_at',
        'completed_at',
        'cancelled_at',
        'expired_at',
        'note',
        'created_by',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'arrived_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function businessNow(): Carbon
    {
        return Carbon::now(self::BUSINESS_TIMEZONE);
    }

    private function reservationDateString(): string
    {
        if ($this->reservation_date instanceof Carbon) {
            return $this->reservation_date->format('Y-m-d');
        }

        return Carbon::parse($this->reservation_date, self::BUSINESS_TIMEZONE)->format('Y-m-d');
    }

    private function normalizeTime($time): ?string
    {
        if (! $time) {
            return null;
        }

        return Carbon::parse($time, self::BUSINESS_TIMEZONE)->format('H:i:s');
    }

    public function startDateTime(): Carbon
    {
        return Carbon::parse($this->reservationDateString() . ' ' . $this->normalizeTime($this->start_time), self::BUSINESS_TIMEZONE);
    }

    public function estimatedEndDateTime(): Carbon
    {
        $endTime = $this->normalizeTime($this->estimated_end_time ?: $this->end_time);

        if (! $endTime) {
            return $this->startDateTime()->copy()->addHours(2);
        }

        return Carbon::parse($this->reservationDateString() . ' ' . $endTime, self::BUSINESS_TIMEZONE);
    }

    public function formattedDate(): string
    {
        return Carbon::parse($this->reservationDateString(), self::BUSINESS_TIMEZONE)->format('d.m.Y');
    }

    public function formattedStartTime(): string
    {
        return Carbon::parse($this->start_time, self::BUSINESS_TIMEZONE)->format('H:i');
    }

    public function formattedEstimatedEndTime(): ?string
    {
        $endTime = $this->estimated_end_time ?: $this->end_time;

        return $endTime ? Carbon::parse($endTime, self::BUSINESS_TIMEZONE)->format('H:i') : null;
    }

    public function durationLabel(): string
    {
        return $this->formattedStartTime()
            . ' - '
            . ($this->formattedEstimatedEndTime() ?: $this->startDateTime()->copy()->addHours(2)->format('H:i'));
    }

    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }

    public function isArrived(): bool
    {
        return $this->status === 'arrived';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['reserved', 'arrived'], true);
    }

    public function isUpcoming(): bool
    {
        return $this->isReserved()
            && self::businessNow()->lt($this->startDateTime()->copy()->subMinutes(15));
    }

    public function isDueSoon($minutes = 15): bool
    {
        if (! $this->isReserved()) {
            return false;
        }

        $now = now();
        $start = $this->startDateTime();

        return $now->gte(
            $start->copy()->subMinutes($minutes)
        )
            && $now->lt($start);
    }

    public function isLate($minutes = 15): bool
    {
        return $this->isReserved()
            && self::businessNow()->gt($this->startDateTime()->copy()->addMinutes($minutes));
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['reserved', 'arrived']);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('reservation_date', Carbon::parse($date, self::BUSINESS_TIMEZONE)->format('Y-m-d'));
    }

    public function scopeForTable($query, $tableId)
    {
        return $query->where('table_id', $tableId);
    }

    public static function hasConflict($tableId, $date, $startTime, $estimatedEndTime = null, $ignoreId = null): bool
    {
        $date = Carbon::parse($date, self::BUSINESS_TIMEZONE)->format('Y-m-d');
        $start = Carbon::parse($date . ' ' . Carbon::parse($startTime, self::BUSINESS_TIMEZONE)->format('H:i:s'), self::BUSINESS_TIMEZONE);
        $end = $estimatedEndTime
            ? Carbon::parse($date . ' ' . Carbon::parse($estimatedEndTime, self::BUSINESS_TIMEZONE)->format('H:i:s'), self::BUSINESS_TIMEZONE)
            : $start->copy()->addHours(2);

        return self::query()
            ->where('table_id', $tableId)
            ->whereDate('reservation_date', $date)
            ->whereIn('status', ['reserved', 'arrived'])
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->get()
            ->contains(function ($reservation) use ($start, $end) {
                return $start->lt($reservation->estimatedEndDateTime())
                    && $end->gt($reservation->startDateTime());
            });
    }
}
