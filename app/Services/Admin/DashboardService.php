<?php

namespace App\Services\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Rental\RentalResource;
use App\Http\Resources\Type\TypesResource;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService extends BaseController{
    public function rentalDetails()
    {
        $now = Carbon::now();

        $lastRentedDetails = Rental::with('car')
                                    ->where(function ($query) use ($now) {
                                        $query->where('drop_off_date', '>', $now->format('Y-m-d'))
                                            ->orWhere(function ($q) use ($now) {
                                                $q->where('drop_off_date', '=', $now->format('Y-m-d'))
                                                    ->where('drop_off_time', '>', $now->format('H:i:s'));
                                            });
                                    })
                                    ->orderByRaw("DATEDIFF(drop_off_date, ?) DESC", [$now->format('Y-m-d')])
                                    ->orderBy('id', 'DESC')
                                    ->first();
        if(!$lastRentedDetails){
            return $this->sendError('not data found because there is not cars rented yet.');
        }

        return $this->sendResponse( new RentalResource($lastRentedDetails), 'Rental details information .');
    }

    public function topCarTypes()
    {
        $topTypes = DB::table('types')
                        ->select(
                            'types.id',
                            'types.name',
                            DB::raw('COUNT(rentals.id) as rental_count')
                        )
                        ->join('cars', 'types.id', '=', 'cars.type_id')
                        ->leftJoin('rentals', 'cars.id', '=', 'rentals.car_id')
                        ->groupBy('types.id', 'types.name')
                        ->orderBy('rental_count', 'DESC')
                        ->get();

    return $this->sendResponse( TypesResource::collection($topTypes), 'Top five car rental types .');
    }

    public function lastTransaction()
    {
        $rental = Rental::latest()->take(4)->get();

        if(!$rental){
            return $this->sendError('not data found because there is not cars rented yet.');
        }
        
        return $this->sendResponse(  RentalResource::collection($rental), 'Last rental transaction .');
    }

}
