<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\RegisterRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientAuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $client = Client::create($input);

        $success['token'] = $client->createToken('Client')->plainTextToken;
        $success['client'] = [
            'name' => $client->name,
            'job' => $client->job,
            'email' => $client->email,
        ];

        return $this->sendResponse($success, 'Client registered successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    // public function login(Request $request)
    // {
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('Client')->plainTextToken;
    //         $success['name'] =  $user->name;

    //         return $this->sendResponse($success, 'User login successfully.');
    //     }
    //     else{
    //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //     }
    // }
}
