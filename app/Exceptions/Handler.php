<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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


        // for handling authenticationexception for admin and normal users

        $class = get_class($exception);

        switch($class) {
            case 'Illuminate\Auth\AuthenticationException':

            // if request expectsJson send thiss
                if($request->expectsJson()){
                    return response()->json(['message' => $exception->getMessage()], 401);
                }
            // else if it is a web request do this
                $guard = array_get($exception->guards(), 0);
                switch ($guard) {
                    case 'admin':
                        $login = 'admin.login';
                        break;
                    default:
                        $login = 'login';
                        break;
                }

                return redirect()->route($login);
            break;
        }

        // end admin and normal users

        return parent::render($request, $exception);
    }
}
