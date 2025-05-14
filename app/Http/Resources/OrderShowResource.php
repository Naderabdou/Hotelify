<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orderResource = new OrderResource($this);
        $data = [
            'order_text' => $this->getText(),
            'step' => $this->getStep(),
        ];

        return array_merge($orderResource->toArray($request), $data);
    }



    public function getText()
    {
        \Carbon\Carbon::setLocale(app()->getLocale());

        $bookingDate = $this->created_at->copy();

        $text = __("حجزت هذا الطلب في يوم") . ' ' . $bookingDate->translatedFormat('l') . ' ' . $bookingDate->translatedFormat('d M');

        if ($this->expected_delivery_time && $this->status != 'canceled') {
            $deliveryDate = $bookingDate->copy()->addDays($this->expected_delivery_time);
            $text .= ' ' . __('و متوقع التسليم يوم') . ' ' . $deliveryDate->translatedFormat('l') . ' ' . $deliveryDate->translatedFormat('d M');
        }

        return $text;
    }

    public function getStep()
    {
        return match ($this->status) {

            'pending' => 0,
            'accepted' => 1,
            'received' =>2,
            'washing' => 3,
            'ready' => 4,
            'on_the_way' => 5,
            'completed' => 6,
            default => 0,
        };
    }
}
