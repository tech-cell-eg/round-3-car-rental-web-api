<?php

namespace App\Services\Cars\CarsService;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CarResource;
use App\Models\Car;

class CarsService extends BaseController{
    public function index()
    {
        $cars = CarResource::collection(Car::all());
        return $this->sendResponse($cars, 'Cars retrieved successfully');
    }
}
