<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\Base\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends ApiRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ];
    }
}
