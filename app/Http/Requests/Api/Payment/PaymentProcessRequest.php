<?php

namespace App\Http\Requests\Api\Payment;

use App\Http\Requests\Api\Base\ApiRequest;

class PaymentProcessRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'car_id' => 'required|integer|exists:cars,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'pickUpLocation' => 'required|exists:cities,id',
            'pickUpDate' => [
                'required',
                'date_format:d/m/Y',
                'after_or_equal:' . now()->format('d/m/Y'),
                'before_or_equal:drop_off_date'
            ],
            'pickUpTime' => 'required|date_format:H:i',
            'dropOffLocation' => 'required|exists:cities,id',
            'dropOffDate' => [
                'required',
                'date_format:d/m/Y',
                'after_or_equal:' . now()->addDay()->format('d/m/Y'),
            ],
            'dropOffTime' => 'required|date_format:H:i|after:pick_up_time',
            'cardNumber' => 'required|digits:16|numeric',
            'expiryDate' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^([0-9]{1,2})[\/\-]?([0-9]{2})$/', $value, $matches)) {
                        $fail('The expiry date format is invalid.');
                        return;
                    }

                    $month = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                    $year = 2000 + $matches[2];

                    if ($month < 1 || $month > 12) {
                        $fail('Invalid month.');
                    }

                    if ($year < date('Y') || ($year == date('Y') && $month < date('m'))) {
                        $fail('The card has expired.');
                    }
                },
            ],
            'cardHolder' => 'required|string|min:6',
            'cvc' => 'required|digits:3',
            'termsAccepted' => 'required|accepted',
        ];
    }
}
