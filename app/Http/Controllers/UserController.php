<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TokenAccess;
use App\Mail\ConfirmacaoEmail;
use Illuminate\Support\Facades\Mail; 
use App\Jobs\EnviarEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'cpf' => 'required',
            'empresa' => 'required',
            'password' => 'required',
            'perfil' => 'required'
        ]);

        if (User::where('email', '=', $request->email)->orWhere('cpf', '=', $request->cpf)->exists())
            return response()->json(['message' => 'Usuário já foi cadastrado!']);     

            $user = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'empresa' => $request->empresa,
                'password' => Hash::make($request->password),
                'active' => false,
                'perfil_id' => $request->input('perfil.id')
            ]); 
            
           $tokenAcess = TokenAccess::create([
                'user_id' => $user->id,
                'tipo' => 'ACTIVE',
                'token' => Str::random(80),
                'validade' => Carbon::now()->addMinutes(10)           
            ]);

            EnviarEmail::dispatch($user, $tokenAcess, 'CHECK');
    }

 
    public function show($id)
    {

        if (User::where('id', '=', $id)->exists()){            
            return User::find($id)->with('perfil')->find($id);
        } 

       return response()->json(['message' => 'Usuário não encontrado']); 
    }

    public function edit($id)
    {
        //
    }
    

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function forgot(Request $request)
    {  
 
        if (User::where('email', $request->email) 
        ->where('active', '=', true)
        ->exists()){
            $user = User::where('email', $request->email)->first();
            $tokenAcess = TokenAccess::create([
                'user_id' => $user->id,
                'tipo' => 'ACTIVE',
                'token' => Str::random(128),
                'validade' => Carbon::now()->addMinutes(10)           
            ]);    
           EnviarEmail::dispatch($user, $tokenAcess, 'RESET');
           return response()->json(['message' => 'Redefinição de senha enviada com sucesso!']);
            }      
        return response()->json(['message' => 'Usuário não encontrado']);
    }

    public function reset(Request $request)
    {   
        if (TokenAccess::where('user_id', $request->id)
        ->where('token', $request->token)
        ->where('validade', '>=', Carbon::now())
        ->where('active', '=', false)
        ->exists()){

            if ($user = User::find($request->id)->exists()){
                User::find($request->id)
                    ->update(['password' => Hash::make($request->password)]);
            }

            TokenAccess::where(['token' => $request->token])
            ->delete();
            return view('success-reset-password');     
        } 
        return 'Falha ao alterar senha!';
    }

    public function valid($id, $token)
    {   
        if (TokenAccess::where('user_id', $id)
        ->where('token', $token)
        ->where('validade', '>=', Carbon::now())
        ->where('active', '=', false)
        ->exists()){
            return  view('reset-password', ['id' => $id, 'token' => $token]);    
        } 
        abort(500);
    }

}
