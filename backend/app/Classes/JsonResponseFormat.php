<?php

namespace App\Classes;

use Illuminate\Http\JsonResponse;

class JsonResponseFormat
{

    /**
     * Returns custom json format
     *
     * @param array $data
     * @return JsonResponse
     */
    public function getJsonResponse(array $data): JsonResponse
    {
        return response()->json([
            'message' => $data['message'] ?? null,
            'error' => $data['error'] ?? null,
            'details' => [
                'current_page' => $data['current_page'] ?? null,
                'from' => $data['from'] ?? null,
                'to' => $data['to'] ?? null,
                'last_page' => $data['last_page'] ?? null,
                'total' => $data['total'] ?? null,
            ],
            'body' => $data['body'] ?? null,
        ], $data['status'] ?? 200);
    }
}
