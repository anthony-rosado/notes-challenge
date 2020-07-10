<?php


namespace App\Helpers;


use Illuminate\Http\Response;

abstract class ApiResponse
{
    public static function success($data, $message = null)
    {
        return response()->json(compact('data', 'message'), Response::HTTP_OK);
    }

    public static function failed($errors, $message)
    {
        return response()->json(compact('errors', 'message'), Response::HTTP_OK);
    }
}
