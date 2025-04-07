<?php

use App\Http\Controllers\Api\Car\CarsController;
use App\Http\Controllers\Api\Client\ClientAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    ######################### Client Auth #######################
    Route::controller(ClientAuthController::class)->group(function(){
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::get('/cars', function(){
        return 'Worked' ;
    });

    Route::get('/cars',[CarsController::class,'index']);
});
