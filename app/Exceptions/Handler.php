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
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'Recurso não encontrado!',
                    'error' => [$e->getPrevious()]
                ], 404);               
            }else{ 
                //return response(view('angular'), 404);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'Recurso não encontrado!'
                ], 404);               
            } 
        });
 
        $this->renderable(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'Falha na requisição!',
                    'error' => [$e->getPrevious()]
                ], 404);               
            } 
        });

        
        $this->renderable(function (InvalidArgumentException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'Formato inválido!',
                    'error' => [$e->getPrevious()]
                ], 404);               
            } 
        });
 
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'A requisição não foi processada!',
                    'error' => [$e->getPrevious()]
                ], 422);               
            } 
        }); 

        
        $this->renderable(function (NoTypeDetectedException $e, Request $request) {
            if ($request->is('api/*')) { 
                return response()->json([
                    'message' => 'Erro ao processar arquivo!',
                    'error' => [$e->getPrevious()]
                ], 422);               
            } 
        }); 
        
 
    }
}
