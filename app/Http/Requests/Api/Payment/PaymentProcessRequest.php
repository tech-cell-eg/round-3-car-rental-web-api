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
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_address' => 'required|string|max:500',
            'client_city' => 'required|string|max:100',
            'pick_up_city_id' => 'required|exists:cities,id',
            'pick_up_date' => [
                'required',
                'date_format:d/m/Y',
                'after_or_equal:' . now()->format('d/m/Y'),
                'before_or_equal:drop_off_date'
            ],
            'pick_up_time' => 'required|date_format:H:i',
            'drop_off_city_id' => 'required|exists:cities,id',
            'drop_off_date' => [
                'required',
                'date_format:d/m/Y',
                'after_or_equal:' . now()->addDay()->format('d/m/Y'),
            ],
            'drop_off_time' => 'required|date_format:H:i|after:pick_up_time',
            'terms_accepted' => 'required|accepted',
        ];
    }
}
