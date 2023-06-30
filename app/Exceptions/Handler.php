<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\InvalidOrderException;
use Illuminate\Support\Str;


class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'Recurso não encontrado.'
                ], 404);               
            }else{ 
                return response(view('angular'), 404);
            }
        });
        
    }  

    public function render($request, Throwable $exception)
{ 
    $response = parent::render($request, $exception); 
    if ($response->status() === 500) {
        return response(view('error'), 500);
    } 
    return $response; 
 
}
}
