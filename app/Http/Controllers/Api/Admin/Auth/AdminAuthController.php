<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AdminLoginRequest $request)
    {
        $input = $request->validated();
        if(Auth::attempt(['email' =>  $input['email'], 'password' =>  $input['password']])){

            $user = Auth::user();
            $success['token'] =  $user->createToken('Admin')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'Admin login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
