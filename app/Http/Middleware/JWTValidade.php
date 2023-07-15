<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



class JWTValidade extends BaseMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {

            $output = new \Symfony\Component\Console\Output\ConsoleOutput();

            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $payload = auth()->payload();
            $isValidRole = false;

            foreach ($roles as $role) {
                if($user->perfil->role == $role){
                    $isValidRole = true;
                }
            }

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

            if($isValidRole == false)
                return $this->unauthorized('Usuário sem permissão!');

            } catch (TokenExpiredException $e) {
                return $this->unauthorized('Token expirado!');
            } catch (TokenInvalidException $e) {
                return $this->unauthorized('Token inválido!');
            }catch (JWTException $e) {
                return $this->unauthorized('Não autorizado!');
            }
            return $next($request);

            return $this->unauthorized();
        }

        private function unauthorized($message = null){
            return response()->json([
                'message' => $message ? $message : 'Não autorizado!'
            ], 401);
        }
    }
