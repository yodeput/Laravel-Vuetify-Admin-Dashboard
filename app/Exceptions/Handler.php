<?php

namespace App\Exceptions;

use App\Traits\CustomResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Illuminate\Http\Response;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class Handler extends ExceptionHandler
{

    use CustomResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        $this->renderable(function(TokenInvalidException $e, $request){
            return $this->errorResponse('message.token_invalid', 401);
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return $this->errorResponse('message.token_expired', 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return $this->errorResponse('message.token_not_parsed', 401);
        });
    }
}
