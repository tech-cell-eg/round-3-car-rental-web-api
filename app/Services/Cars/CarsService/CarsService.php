<?php

namespace App\Services\Cars\CarsService;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsService extends BaseController{
    public function index(Request $request)
    {
        $cars = Car::with('type')->where(function($q) use($request){
            if ($request->filled('type_ids')) {
                $typeIds = is_array($request->type_ids)
                    ? $request->type_ids
                    : explode(',', $request->type_ids);

                $q->whereIn('type_id', $typeIds);
            }
        })->get();

        return $this->sendResponse(CarResource::collection($cars), 'Cars filtered successfully');
    }

}
