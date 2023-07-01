<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TokenAccess;  
use App\Jobs\EnviarEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Throwable;


class SecurityController extends Controller
{
    public function forgot(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'bail|required' 
          ],
          [
              'email.required' => 'Email é obrigatório!' 
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
    
        if (User:: where('email', $request -> email)
          -> where('active', '=', true)
          -> exists()) {
          $user = User:: where('email', $request -> email) -> first();
          $tokenAcess = TokenAccess:: create([
            'user_id' => $user -> id,
            'tipo' => 'ACTIVE',
            'token' => Str:: random(254),
            'validade' => Carbon:: now() -> addMinutes(10)
          ]);
          EnviarEmail:: dispatch($user, $tokenAcess, 'RESET');
          return response() -> json(['message' => 'Redefinição de senha enviada com sucesso!']);
        }
        return response() -> json(['message' => 'Usuário não encontrado ou inativo']);
      }
    
      public function resend(Request $request) {
    
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required' 
          ],
          [
              'email.required' => 'Email é obrigatório!' 
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
    
        if (User:: where('email', $request -> email)
          -> where('active', '=', false)
          -> exists()) {
          $user = User:: where('email', $request -> email) -> first();
          $tokenAcess = TokenAccess:: create([
            'user_id' => $user -> id,
            'tipo' => 'ACTIVE',
            'token' => Str:: random(254),
            'validade' => Carbon:: now() -> addMinutes(10)
          ]);
          EnviarEmail:: dispatch($user, $tokenAcess, 'CHECK');
          return response() -> json(['message' => 'Ativação enviada com sucesso!']);
        }
        return response() -> json(['message' => 'Usuário não encontrado ou ativo']);
      }
    
      public function reset(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'bail|required',
            'token' => 'bail|required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase(1)->symbols(1)->numbers(1)] 
          ],
          [
            'id.required' => 'Id é obrigatório!',
            'token.required' => 'Token é inválido!'
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);    
  
        if (TokenAccess:: where('user_id', $request -> id)
          -> where('token', $request -> token)
          -> where('validade', '>=', Carbon:: now())
          -> where('active', '=', false)
          -> exists()) {
    
          if ($user = User:: find($request -> id) -> exists()) {
            User:: find($request -> id)
              -> update(['password' => Hash:: make($request -> password)]);
          }
    
          TokenAccess:: where(['token' => $request -> token])
            -> delete ();
            return response() -> json(['message' => 'Senha alterada com sucesso!'], 200);
        }
        return response()->json(['errors' => 'Falha ao atualiza senha!', 'status' => 400], 400);
      }
    
      public function valid($id, $token) {
        if (TokenAccess:: where('user_id', $id)
          -> where('token', $token)
          -> where('validade', '>=', Carbon:: now())
          -> where('active', '=', false)
          -> exists()) {
          return view('reset-password', ['id' => $id, 'token' => $token]);
        }
        abort(404);
      }
    
      public function active($id, $token)
      {
          if (TokenAccess::where('user_id', $id)
          ->where('token', $token)
          ->where('validade', '>=', Carbon::now())
          ->where('active', '=', false)
          ->exists()){
    
              if (User::find($id)->exists()){
                  User::find($id)
                      ->update(['active' => true]);
              }
    
              TokenAccess::where(['token' => $token])
              ->update(['active' => true]);
              return view('active-account');       
          }
          return 'Link expirou ou é inválido!'; 
      }
    
}
