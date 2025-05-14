<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_number',
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getCountReservationAttribute()
    {
        return Carbon::parse($this->start_date)
            ->diffInDays(Carbon::parse($this->end_date));
    }


    public static function getAllowedTransitions(): array
    {
        return [
            'pending' => ['confirmed', 'canceled'],
            'confirmed' => [],
            'canceled' => [],
        ];
    }

    public function canChangeStatusTo(string $newStatus): bool
    {
        $transitions = self::getAllowedTransitions();

        if (!isset($transitions[$this->status])) {
            return false;
        }

        return in_array($newStatus, $transitions[$this->status]);
    }

    public function getAllowedNextStatuses(): string
    {
        $transitions = self::getAllowedTransitions();
        return implode(', ', $transitions[$this->status] ?? []);
    }
}
