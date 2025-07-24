<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception)
    {
        // Log directly to stderr so Render can capture the error
        error_log("🚨 Laravel Exception: " . $exception->getMessage());

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
