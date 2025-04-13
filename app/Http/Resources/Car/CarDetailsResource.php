<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CarDetailsResource extends JsonResource
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
            'mainImage' => $this->image,
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($img) {
                    return url(Storage::url('cars/' . $img->image));
                });
            }),
            'type' => $this->whenLoaded('type', $this->type->name),
            'gasoline' => $this->gasoline,
            'seats' => $this->capacity,
            'steering' => $this->steering,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'reviews' => $this->whenLoaded('reviews', function () {
                return [
                    'total' => $this->reviews->count() ?? 0,
                    'average_rating' => $this->reviews->isNotEmpty() ? round($this->reviews->avg('rating'), 1) : 0,
                    'breakdown' => [
                        '1_star' => $this->reviews->where('rating', 1)->count() ?? 0,
                        '2_star' => $this->reviews->where('rating', 2)->count() ?? 0,
                        '3_star' => $this->reviews->where('rating', 3)->count() ?? 0,
                        '4_star' => $this->reviews->where('rating', 4)->count() ?? 0,
                        '5_star' => $this->reviews->where('rating', 5)->count() ?? 0,
                    ]
                ];
            }, null),
        ];
    }
}
