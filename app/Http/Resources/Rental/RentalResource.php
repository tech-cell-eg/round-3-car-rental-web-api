<?php

namespace App\Http\Resources\Rental;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
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
            'name' => $this->client_name,
            'phone' => $this->client_phone,
            'address' => $this->client_address,
            'city' => $this->client_city,
            'pickUpLocation' => $this->whenLoaded('pickupCity', $this->pickupCity->name),
            'dropOffLocation' => $this->whenLoaded('dropoffCity', $this->dropoffCity->name),
            'pickUpDate' => $this->pick_up_date,
            'dropOffDate' => $this->drop_off_date,
            'pickUpTime' => $this->pick_up_time,
            'dropOffTime' => $this->drop_off_time,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'car' => $this->whenLoaded('car', function () {
                return [
                    'name' => $this->car->name,
                    'image' => $this->car->image,
                    'type' => $this->car->type->name,
                    // 'image' => asset('storage/' . $this->car->image),
                ];
            }),
        ];
    }
}
