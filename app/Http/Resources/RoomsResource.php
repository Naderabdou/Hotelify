<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomsResource extends JsonResource
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
            'number' => $this->number,
            'type' => $this->type,
            'pirce_per_night' => $this->price_per_night . ' ' . __('EGP'),
        ];
    }
}
