<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Account\User;
use App\Models\Account\TokenAccess; 
use App\Jobs\EnviarEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;
use Throwable;


class UserController extends Controller {

  public function index() {
    //
  }

  public function create() {
    //
  }


  public function store(Request $request) {

    $validator = Validator::make($request->all(), [
      'nome' => 'bail|required',
      'email' => 'bail|required',
      'cpf' => 'bail|required',
      'empresa' => 'bail|required',
      'password' => ['required', 'confirmed', Password::min(8)->mixedCase(1)->symbols(1)->numbers(1)],
      'perfil' => 'bail|required',
      'telefone' => 'bail|required'
    ],
    [
        'nome.required' => 'Nome é obrigatório!',
        'email.required' => 'Email é obrigatório!',
        'cpf.required' => 'Documento é obrigatório!',
        'empresa.required' => 'Empresa é obrigatório!',  
        'telefone.required' => 'Telefone é obrigatório!', 
        'perfil' => 'Perfil é obrigatório!',
    ]);

    if ($validator->fails())
        return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
 

    if (User:: where('email', '=', $request -> email) -> orWhere('cpf', '=', $request -> cpf) -> exists())
    return response() -> json(['message' => 'Usuário já foi cadastrado!']);

    $user = User:: create([
      'nome' => $request -> nome,
      'email' => $request -> email,
      'cpf' => $request -> cpf,
      'empresa' => $request -> empresa,
      'password' => Hash:: make($request -> password),
      'active' => false,
      'telefone' => $request -> telefone,
      'perfil_id' => $request -> input('perfil.id')
    ]);

    $tokenAcess = TokenAccess:: create([
      'user_id' => $user -> id,
      'tipo' => 'ACTIVE',
      'token' => Str:: random(254),
      'validade' => Carbon:: now() -> addMinutes(10)
    ]);

    Log::channel('db')->info(
      'Criado usuario' .$user -> id. ' com usuario ' . $user->nome. ' e previlégios ' .$user->perfil->role);

    EnviarEmail:: dispatch($user, $tokenAcess, 'CHECK');
  }


  public function show($id) {
 
      $user = User::with ('perfil') -> firstWhere('id', $id);
      if($user === null)
        return response()->json(['message' => env('RESPONSE_NOT_FOUND'), 'status' => 202], 202);
    return $user;  
  }

  public function search($search) { 

   if( Str::length($search) > 2)
    return User::where('nome', 'LIKE', '%'.$search.'%')
    ->orWhere('email', 'LIKE', '%'.$search.'%')
    ->orWhere('cpf', 'LIKE', '%'.$search.'%')
    ->orWhere('empresa', 'LIKE', '%'.$search.'%')
    ->get(); 
    return response() -> json(['message' => 'Necessário ao menos 3 caracteres!'], 201);
  }

  public function edit(Request $request) {
 
    $validator = Validator::make($request->all(), [
      'nome' => 'bail|required',
      'email' => 'bail|required',
      'cpf' => 'bail|required',
      'empresa' => 'bail|required',
      'telefone' => 'bail|required'
    ],
    [
        'nome.required' => 'Nome é obrigatório!',
        'email.required' => 'Email é obrigatório!',
        'cpf.required' => 'Documento é obrigatório!',
        'empresa.required' => 'Empresa é obrigatório!',
        'telefone.required' => 'Empresa é obrigatório!', 
    ]);

    if ($validator->fails())
        return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
 
    try {
      $token = JWTAuth:: parseToken();
      $userAuth = $token -> authenticate();

      if ($userAuth -> perfil -> role !== 'ROOT')
        if ($userAuth !== $request -> id)
      return response() -> json(['error' => 'Não é possivel atualizar este usuário!']);
 
      $userDB = User::firstWhere('id', $request -> id)
        -> update([
          'nome' => $request -> email,
          'nome' => $request -> nome,
          'cpf' => $request -> cpf,
          'empresa' => $request -> empresa,
          'telefone' => $request -> telefone]);
      Log::channel('db')->info(
          'Editado usuario' .$request -> email. ' com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);      


    } catch (Throwable $e) {
      return response() -> json(['error' => 'Falha ao atualizar cadastro!']);
    }
  }
 
  public function destroy($id) {

    try {
        $token = JWTAuth:: parseToken();
        $userAuth = $token -> authenticate();
  
      if ($userAuth -> perfil -> role === 'ROOT'){
          User::destroy($id); 
      Log::channel('db')->info(
          'Delete usuario' .$id. ' com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);   
      } 
      else{
        Log::channel('db')->info(
          'Delete não conlcuido usuario' .$id. ' com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);  
      } 
  
      } catch (Throwable $e) {
        return response() -> json(['error' => 'Falha ao remover cadastro!']);
      }
  }
}
