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
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'client_address' => $this->client_address,
            'client_city' => $this->client_city,
            'pick_up_date' => $this->pick_up_date,
            'pick_up_time' => $this->pick_up_time,
            'drop_off_date' => $this->drop_off_date,
            'drop_off_time' => $this->drop_off_time,
            'rental_days' => $this->rental_days,
            'payment_method' => $this->payment_method,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'car' => $this->whenLoaded('car', function () {
                return [
                    'name' => $this->car->name,
                    'image' => $this->car->image,
                    // 'image' => asset('storage/' . $this->car->image),
                ];
            }),
        ];
    }
}
