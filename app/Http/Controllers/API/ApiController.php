<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Validator;

class ApiController extends BaseController
{

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'role'=>'Admin'])) {
            $user = Auth::user();
            $success['token'] =  'Bearer '.$user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Email or Paswword Incorrect', ['error'=>'Unauthorised']);
        }
    }
      
}
