<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use InvalidArgumentException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;


class Handler extends ExceptionHandler
{

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {


        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'errors' => array('A requisição não foi processada!')
                ], 422);
            }
        });


        $this->renderable(function (NoTypeDetectedException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'errors' => array('Erro ao processar arquivo!')
                ], 422);
            }
        });


    }
}
