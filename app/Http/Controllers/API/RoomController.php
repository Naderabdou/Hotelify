<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomsResource;
use App\Http\Requests\API\RoomFilterDateRequest;
use App\Http\Controllers\API\Traits\ApiResponseTrait;

class RoomController extends Controller
{
    use ApiResponseTrait;
    public function index(RoomFilterDateRequest $request)
    {
        

        $query = Room::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->availableBetween($request->start_date, $request->end_date);
        } elseif ($request->filled('start_date')) {
            $query->availableBetween($request->start_date, $request->start_date);
        } else {
            $query->where('is_available', true);
        }

        $rooms = $query->paginate(10);

        return $this->ApiPaginationResponse(RoomsResource::collection($rooms));
    }
}
