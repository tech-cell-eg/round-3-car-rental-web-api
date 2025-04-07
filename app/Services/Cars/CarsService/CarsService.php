<?php

namespace App\Services\Cars\CarsService;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Car\CarDetailsResource;
use App\Http\Resources\Car\CarsResource;
use App\Models\Car;

class CarsService extends BaseController{
    public function index($request)
    {
        $cars = Car::with('type')->where(function($q) use($request){
            if ($request->filled('type_ids')) {
                $typeIds = is_array($request->type_ids)
                    ? $request->type_ids
                    : explode(',', $request->type_ids);

                $q->whereIn('type_id', $typeIds);
            }
        })->get();

        return $this->sendResponse(CarsResource::collection($cars), 'Cars filtered successfully');
    }

    public function carDetails($request)
    {
        $car = Car::with('type','images')->find($request->input('id'));

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

}
