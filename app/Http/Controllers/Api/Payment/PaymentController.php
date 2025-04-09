<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Payment\PaymentProcessRequest;
use App\Services\Payments\CheckoutService;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    protected CheckoutService $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {

        $this->checkoutService = $checkoutService;
    }


    public function checkout(PaymentProcessRequest $request)
    {
        return $this->checkoutService->checkout($request);
    }

    // public function handleWebhook(Request $request)
    // {
    //     return $this->checkoutService->handleWebhook($request);
    // }


    public function success()
    {

        return view('payment-success');
    }
    public function failed()
    {

        return view('payment-failed');
    }
}
