<?php

namespace App\Http\Controllers\Exceptions;

use Illuminate\Validation\ValidationException as BaseValidationException;

class ValidationException extends BaseValidationException
{
    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $this->errors(),
        ], 422);
    }
}