<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CnicMobileConflictException extends Exception
{
    public const MESSAGE = 'This mobile number is already registered with another CNIC and cannot be linked to this CNIC.';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }

    public function toValidationException(string $attribute = 'mobile_number'): ValidationException
    {
        return ValidationException::withMessages([
            $attribute => [$this->getMessage()],
        ]);
    }

    public function render(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'status' => false,
                'message' => $this->getMessage(),
                'errors' => [
                    'mobile_number' => [$this->getMessage()],
                ],
            ], 422);
        }

        return redirect()->back()->withInput()->withErrors([
            'mobile_number' => $this->getMessage(),
        ]);
    }
}
