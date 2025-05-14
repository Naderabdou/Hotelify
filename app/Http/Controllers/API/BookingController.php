<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderStoreRequest;

class BookingController extends Controller
{


    public function store(OrderStoreRequest $request, BookingService $orderBooking)
    {

        $data = $request->validated();
        $room = Room::where('is_available', true)->find($data['room_id']);
        $user = auth()->user();

        return $orderBooking->create($user, $data, $room);
    }
}
