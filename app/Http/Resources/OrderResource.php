<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'service_name' => $this->service_name,
            'total_price' => $this->total_price . ' ' . __('SAR'),
            'quantity' => $this->quantity,
            'pickup_date' => $this->pickup_date->format('Y-m-d'),
            'pickup_time' => $this->pickup_time->format('h:i A'),
            'address' => $this->full_address,
            'address_notes' => $this->address_notes,
            'status' => $this->status === 'canceled'
                ? ($this->canceled_type === 'user' ? __('canceled_by_user') : __('canceled_by_admin'))
                : __($this->status),
            'canceled_type' => __($this->canceled_type) ?? null,
            'can_canceled' => $this->status == 'pending' ? true : false,
        ];
    }
}
