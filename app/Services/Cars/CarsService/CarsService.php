<?php

namespace App\Services\Cars\CarsService;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Car\CarDetailsResource;
use App\Http\Resources\Car\CarReviewsResource;
use App\Http\Resources\Car\CarsResource;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsService extends BaseController{
    public function index(Request $request)
    {
        $cars = Car::with('type')->where(function($q) use($request) {
            // Filter by type names (array of names)
            if ($request->filled('type')) {
                $types = is_array($request->type)
                    ? $request->type
                    : explode(',', $request->type);

                $q->whereHas('type', function($typeQuery) use($types) {
                    $typeQuery->where(function($subQuery) use($types) {
                        foreach ($types as $name) {
                            $subQuery->orWhere('name', 'like', '%' . $name . '%');
                        }
                    });
                });
            }

            // Filter by capacity
            if ($request->filled('capacity')) {
                $capacities = is_array($request->capacity)
                    ? $request->capacity
                    : explode(',', $request->capacity);
                $q->whereIn('capacity', $capacities);
            }

            // Filter by price range
            if ($request->filled('max_price')) {
                $minPrice = $request->filled('min_price') ? $request->min_price : 0;
                $q->whereBetween('price', [$minPrice, $request->max_price]);
            } elseif ($request->filled('min_price')) {
                $q->where('price', '>=', $request->min_price);
            }

        })->get();

        return $this->sendResponse(CarsResource::collection($cars), 'Cars filtered successfully');
    }
    public function carDetails($id)
    {
        $car = Car::with('type','images','reviews')->find($id);

        if(!$car){
            return $this->sendError('Car not found.');
        }

        return $this->sendResponse( new CarDetailsResource($car), 'Car details information');
    }

    public function recentCars()
    {
        $cars = Car::orderBy('id', 'desc')->take(3)->get();
        return $this->sendResponse( CarsResource::collection($cars), 'Recent Cars');
    }

    public function recommendedCars()
    {
        $cars = Car::inRandomOrder()->take(3)->get();
        return $this->sendResponse(CarsResource::collection($cars), 'Recommended Cars');
    }

    public function carReviews($id)
    {
        $car = Car::with(['reviews.client'])->find($id);

        if (!$car) {
            return $this->sendError('Car not found.');
        }

        return $this->sendResponse(
            CarReviewsResource::collection($car->reviews),
            'Car reviews retrieved successfully'
        );
    }

}
