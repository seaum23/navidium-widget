<?php
namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse{

    /**
     * Send Success JSONResponse
     */
    protected function successResponse(array $additional_data = [], string $message = "Success", int $status = 200) : JsonResponse {
        return response()->json(array_merge([
            "status" => $status,
            "message" => $message
        ], $additional_data), $status);
    }

    /**
     * Send Error JSONResponse
     */
    protected function errorResponse(array $additional_data = [], string $message = "Something went wrong", int $status = 204) : JsonResponse {
        return response()->json(array_merge([
            "status" => $status,
            "message" => $message
        ], $additional_data), $status);
    }
}