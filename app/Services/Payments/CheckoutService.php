<?php

namespace App\Services\Payments;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Rental\RentalResource;
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
            return response()->json(['status' => 'failed','error' => 'Car not found'], 404);
        }

        $car_name = $car->name;

        // Use sale price if available, otherwise use regular price
        $pricePerDay = $car->sale_price ?? $car->price;

        // Parse pickup and drop off dates
        $pickupDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('pickUpDate'));
        $dropOffDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('dropOffDate'));

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
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'city' => $request->input('address'),
                'address' => $request->input('city'),
                'pickUpLocation' => $request->input('pickUpLocation'),
                'dropOffLocation' => $request->input('dropOffLocation'),
                'pickUpDate' => $pickupDate,
                'dropOffDate' => $dropOffDate,
                'pickUpTime' => $request->input('pickUpTime'),
                'dropOffTime' => $request->input('dropOffTime'),
                'rental_days' => $rentalDays,
                'cardNumber' => $request->input('cardNumber'),
                'expiryDate' => $request->input('expiryDate'),
                'cardHolder' => $request->input('cardHolder'),
                'cvc' => $request->input('cvc'),
                'paymentMethod' => "CashCard",
                'subtotal' => $subTotal,
                'total_price' => $total,
                'termsAccepted' => $request->boolean('termsAccepted'),
            ];

            // Create rental record
            $rental = Rental::create($rentalData);

            return $this->sendResponse(null,'Payment done successfully');
        }

    }
}
