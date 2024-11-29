<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Laporan pengecualian jika diperlukan
        });
    }

    // Menangani pengecualian validasi secara khusus
    public function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        // Respons standar dari Laravel untuk validasi
        $errors = $e->errors();  // Ambil semua error validasi

        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ], 422);
    }
}
