<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entities\User;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (! Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 422);
        }

        /**@var User $user*/
        $user = Auth::user();
        $accessToken = $user->createToken('login')->accessToken;

        return ApiResponse::success(['access_token' => $accessToken]);
    }
}
