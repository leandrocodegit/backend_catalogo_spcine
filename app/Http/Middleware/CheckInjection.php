<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckInjection
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->nome != null) {
            if (Str::contains($request['nome'], 'SELECT', true)) {
                auth()->logout();
                return $this->unauthorized();
            } else if (Str::contains($request['nome'], 'WHERE', true)) {
                auth()->logout();
                return $this->unauthorized();
            } else if (Str::contains($request['nome'], 'UNION', true)) {
                auth()->logout();
                return $this->unauthorized();
            } else if (Str::contains($request['nome'], 'DELETE', true)) {
                auth()->logout();
                return $this->unauthorized();
            }
            else if (Str::contains($request['nome'], 'JOIN', true)) {
                auth()->logout();
                return $this->unauthorized();
            }
        }
        return $next($request);
    }

    private function unauthorized($message = null){
        return response()->json([
            'errors' => $message ? array($message) : array('Não autorizado!')
        ], 401);
    }
}
