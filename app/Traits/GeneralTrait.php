<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait GeneralTrait
{
    public function returnError($code, $message): JsonResponse
    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'message' => $message
        ]);
    }

    public function returnSuccess($code, $message): JsonResponse
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'message' => $message
        ]);
    }

    public function returnData($code, $message, $data): JsonResponse
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
