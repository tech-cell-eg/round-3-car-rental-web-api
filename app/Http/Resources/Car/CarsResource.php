<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CarsResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image ? url(Storage::url('cars/' . $this->image)) : null,
            'type' => $this->whenLoaded('type', $this->type->name),
            'gasoline' => $this->gasoline,
            'seats' => $this->capacity,
            'steering' => $this->steering,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
        ];
    }
}
