<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseHelper
{
    public function response($data, $status = 200, $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    public function errorResponse($message, $status = 422): JsonResponse
    {
        return new JsonResponse([
            'status' => $status,
            'message' => $message,
        ], $status);
    }

    public function successResponse($message): JsonResponse
    {
        return new JsonResponse([
            'status' => 200,
            'success' => $message,
        ]);
    }
}