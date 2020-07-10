<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entities\User;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        /**@var User $user*/
        $user = User::create($request->validated());
        $accessToken = $user->createToken('login')->accessToken;

        return ApiResponse::created([
            'access_token' => $accessToken,
        ], __('messages.user.registered'));
    }
}
