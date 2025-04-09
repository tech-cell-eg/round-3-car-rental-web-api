<?php

use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Car\CarsController;
use App\Http\Controllers\Api\Client\ClientAuthController;
use App\Http\Controllers\Api\Payment\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cars',[CarsController::class,'index']);



Route::prefix('v1')->group(function () {

    ######################### Admin Auth #######################
    Route::post('/admin/login',[AdminAuthController::class,'login']);

    ######################### Dashboard Analysis #######################
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/details/rental',[DashboardController::class,'rentalDetails']);
        Route::get('/types',[DashboardController::class,'topCarTypes']);
        Route::get('/rental',[DashboardController::class,'lastTransaction']);
    });


    ######################### Client Auth #######################
    Route::controller(ClientAuthController::class)->group(function(){
        Route::post('/client/register', 'register');
        Route::post('/client/login', 'login');
    });


    Route::get('/cars',[CarsController::class,'index']);
    Route::get('/car-details/{id}',[CarsController::class,'carDetails']);
    Route::get('/recent-cars',[CarsController::class,'recentCars']);
    Route::get('/recommended-cars',[CarsController::class,'recommendedCars']);
    Route::get('/car-reviews/{id}',[CarsController::class,'carReviews']);

    Route::post('/rent/checkout', [PaymentController::class, 'checkout']);
    Route::post('/rent/webhook', [PaymentController::class, 'handleWebhook']);

});
