<?php

namespace App\Exceptions;

use App\Models\Alert;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // public function report(Throwable $exception)
    // {
    //     if ($this->shouldReport($exception)) {
    //         $this->logToAlertsTable($exception);
    //     }

    //     parent::report($exception);
    // }

    // private function logToAlertsTable(Throwable $exception)
    // {
    //     $message = $exception->getMessage();
    //     $lineNumber = $exception->getLine();
    //     $file = $exception->getFile();
    //     $error = "$message (Line $lineNumber in $file) -> [ExceptionHandler report]";
    //     Log::error($error);
    //     Alert::create([
    //         'type' => 'error',
    //         'message' => $error,
    //     ]);
    // }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (Str::startsWith($request->path(), 'api') or $request->expectsJson())
            return response()->json(['message' => 'Unauthenticated'], 401);
        else
            return redirect()->guest(route('login'));
    }
}
