<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarReviewsResource extends JsonResource
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
            'client' => $this->whenLoaded('client', function () {
                    return [
                        'name' => $this->client->name,
                        'job' => $this->client->job,
                    ];
                }),
            'rating' => $this->rating,
            'description' => $this->description,
            'created_at' => $this->created_at->format('j F Y'),
        ];
    }
}
