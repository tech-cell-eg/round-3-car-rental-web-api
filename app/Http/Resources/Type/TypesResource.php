<?php

namespace App\Http\Resources\Type;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypesResource extends JsonResource
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
            'total_rentals' => $this->rental_count,
        ];
    }
}
