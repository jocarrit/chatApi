<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return $this->unauthorize($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $errors = [
            "message" => "Unauthenticated",
            "errors"  => [
                "name" => [
                        ""
                ]],
            "meta" => ""
        ];

        if ($request->expectsJson()) {
            //return response()->json(['error' => 'Unauthenticated.'], 401);
            //dd($request->headers);
            return response()->json($errors, 401);
        }

        return redirect()->guest(route('login'));
    }

    protected function unauthorize($request, AuthorizationException $exception)
    {
        $errors = [
            "message" => "Unauthorized",
            "errors"  => [
                "name" => [
                        ""
                ]],
            "meta" => ""
        ];

        if ($request->expectsJson()) {
            //return response()->json(['error' => 'Unauthenticated.'], 401);
            //dd($request->headers);
            return response()->json($errors, 403);
        }

        return redirect()->guest(route('login'));

    }

    protected function validationFailed($request, ValidationException $exception)
    {
        if ($request->expectsJson()) {  
            return response()->json('validation failed', 422);
        }
    }


}
