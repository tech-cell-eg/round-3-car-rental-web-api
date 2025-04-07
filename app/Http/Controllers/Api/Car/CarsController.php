<?php

namespace App\Http\Controllers\Api\Car;

use App\Http\Controllers\Controller;
use App\Services\Cars\CarsService\CarsService;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public $carsService;

    public function __construct(CarsService $carsService)
    {
        $this->carsService = $carsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->carsService->index($request);
    }

    public function carDetails(Request $request)
    {
        return $this->carsService->carDetails($request);
    }

    public function recentCars()
    {
        return $this->carsService->recentCars();
    }

    public function recommendedCars()
    {
        return $this->carsService->recommendedCars();
    }

    public function carReviews(Request $request)
    {
        return $this->carsService->carReviews($request);
    }

}
