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
        User::create($request->validated());

        return ApiResponse::created(null, __('messages.user.registered'));
    }
}
