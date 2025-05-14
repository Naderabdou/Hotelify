<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'type',
        'price_per_night',
        'is_available',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeAvailableBetween($query, $startDate, $endDate)
    {
        return $query->where('is_available', true)
            ->whereDoesntHave('bookings', function ($q) use ($startDate, $endDate) {
                $q->where(function ($sub) use ($startDate, $endDate) {
                    $sub->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
            });
    }
}
