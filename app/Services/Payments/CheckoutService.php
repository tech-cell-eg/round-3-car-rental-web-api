<?php

namespace App\Services\Payments;

use App\Http\Controllers\Api\BaseController;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Stripe\Stripe;
class CheckoutService extends BaseController{
    public function checkout(Request $request){
        Stripe::setApiKey(config('stripe.sk'));

       // Get car details
        $car = Car::find($request->input('car_id'));

        // Ensure the car exists to avoid errors
        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $car_name = $car->name;

        // Use sale price if available, otherwise use regular price
        $pricePerDay = $car->sale_price ?? $car->price;

        // Parse pickup and drop off dates
        $pickupDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('pick_up_date'));
        $dropOffDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('drop_off_date'));

        // Calculate rental days correctly
        $rentalDays = $pickupDate->diffInDays($dropOffDate);

        // Calculate tax and total cost
        $tax = $car->tax;
        $subTotal = $pricePerDay * $rentalDays;
        $total = $subTotal + $tax;

        if (!$car) {
            return $this->sendError('Car not found.');
        }

        $session = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url'  => route('payment.failed'),
            'line_items'  => [
                [
                    'price_data' => [
                        "currency" => "USD",
                        'product_data' => [
                            "name" => $car_name,
                            'description' => 'There is the car that u want to rent it .',
                        ],
                        'unit_amount'  => $total*100,
                    ],
                    'quantity'   => 1,
                ],
            ],
        ]);

        $data = $session->url;

        if($session){

            // Prepare rental data
            $rentalData = [
                'car_id' => $request->input('car_id'),
                'client_name' => $request->input('client_name'),
                'client_phone' => $request->input('client_phone'),
                'client_city' => $request->input('client_city'),
                'client_address' => $request->input('client_address'),
                'pick_up_city_id' => $request->input('pick_up_city_id'),
                'pick_up_date' => $pickupDate,
                'pick_up_time' => $request->input('pick_up_time'),
                'drop_off_city_id' => $request->input('drop_off_city_id'),
                'drop_off_date' => $dropOffDate,
                'drop_off_time' => $request->input('drop_off_time'),
                'rental_days' => $rentalDays,
                'payment_method' => $request->input('payment_method'),
                'subtotal' => $subTotal,
                'total_price' => $total,
                'terms_accepted' => $request->boolean('terms_accepted'),
            ];

            // Create rental record
            $rental = Rental::create($rentalData);

            return $this->sendResponse($data,'You must send Card information to checkout');
        }

    }
}
