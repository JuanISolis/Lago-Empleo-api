<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * Niveles de log por excepción
     */
    protected $levels = [];

    /**
     * Excepciones que no se reportan
     */
    protected $dontReport = [];

    /**
     * Inputs que nunca se muestran en validación
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registrar callbacks de reportes
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Renderizar excepción a respuesta HTTP
     */
    public function render($request, Throwable $exception)
    {
        // Errores de validación como JSON
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $exception->errors(),
            ], 422);
        }

        // Errores de autenticación para API
        if ($exception instanceof AuthenticationException) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'No autenticado',
                ], 401);
            }
        }

        return parent::render($request, $exception);
    }
}
