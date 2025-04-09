<?php

namespace App\Services\Payments;

use App\Http\Controllers\Api\BaseController;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;

class TestCheckoutService extends BaseController
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('stripe.sk'));

        // Get car details
        $car = Car::find($request->input('car_id'));
        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        // Calculate rental price
        $pricePerDay = $car->sale_price ?? $car->price;
        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('start_date'));
        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('end_date'));
        $rentalDays = $startDate->diffInDays($endDate);
        $tax = $car->tax;
        $subTotal = $pricePerDay * $rentalDays;
        $total = $subTotal + $tax;

        // Create Stripe checkout session
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [[
                'price_data' => [
                    "currency" => "USD",
                    'product_data' => ["name" => $car->name],
                    'unit_amount'  => $total * 100,
                ],
                'quantity'   => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('payment.failed'),
            'metadata'    => [
                'car_id' => $request->input('car_id'),
                'client_name' => $request->input('client_name'),
                'client_phone' => $request->input('client_phone'),
                'client_city' => $request->input('client_city'),
                'client_address' => $request->input('client_address'),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'rental_days' => $rentalDays,
                'subtotal' => $subTotal,
                'total_price' => $total,
                'terms_accepted' => $request->boolean('terms_accepted'),
            ],
        ]);

        return $this->sendResponse($session->url, 'Redirect to Stripe for payment.');
    }

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('stripe.sk'));

        $endpointSecret = config('stripe.webhook_secret');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid webhook'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data['object'];

            // Extract rental info from session metadata
            $metadata = $session['metadata'] ?? [];
            $rentalData = [
                'car_id' => $metadata['car_id'],
                'client_name' => $metadata['client_name'],
                'client_phone' => $metadata['client_phone'],
                'client_city' => $metadata['client_city'],
                'client_address' => $metadata['client_address'],
                'start_date' => $metadata['start_date'],
                'end_date' => $metadata['end_date'],
                'start_time' => $metadata['start_time'],
                'end_time' => $metadata['end_time'],
                'rental_days' => $metadata['rental_days'],
                'payment_method' => 'Stripe',
                'subtotal' => $metadata['subtotal'],
                'total_price' => $metadata['total_price'],
                'terms_accepted' => filter_var($metadata['terms_accepted'], FILTER_VALIDATE_BOOLEAN),
            ];

            // Create rental record
            Rental::create($rentalData);
        }

        return response()->json(['status' => 'success']);
    }
}
