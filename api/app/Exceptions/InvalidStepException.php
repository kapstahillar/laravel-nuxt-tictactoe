<?php

namespace App\Exceptions;

use App\Models\ApiError;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidStepException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(new ApiError("Invalid step location"));
    }
}