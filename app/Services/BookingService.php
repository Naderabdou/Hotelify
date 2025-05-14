<?php

namespace App\Services;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\API\Traits\ApiResponseTrait;

class BookingService
{
    use ApiResponseTrait;
    public function create(User $user, array $data, Room $room)
    {
        if ($this->hasConflict($room->id, $data['start_date'], $data['end_date'])) {
            return $this->ApiResponse(null, __('يوجد حجز سابق لنفس الغرفة في نفس التاريخ.'), 400);
        }


        $nights = now()->parse($data['start_date'])->diffInDays(now()->parse($data['end_date']));
        $totalPrice = $nights * $room->price_per_night;

        DB::transaction(function () use ($user, $data, $room, $totalPrice) {
            Booking::create([
                'booking_number' => 'booking_' . substr(uniqid(), -6),
                'user_id'     => $user->id,
                'room_id'     => $room->id,
                'start_date'  => $data['start_date'],
                'end_date'    => $data['end_date'],
                'total_price' => $totalPrice,
            ]);
        });


        $title = 'يريد العميل ' . $user->name . ' طلب حجز غرفة رقم' . $room->number;
        sendNotifyAdmin($title, 'عرض الطلب', route('filament.admin.resources.orders.index'));

        return $this->ApiResponse(null, __('تم حجز الغرفة بنجاح'), 200);
    }

    protected function hasConflict(int $roomId, string $startDate, string $endDate): bool
    {
        return Booking::where('room_id', $roomId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->exists();
    }
}
