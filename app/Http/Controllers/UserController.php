<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarEmail;
use App\Models\Account\TokenAccess;
use App\Models\Account\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{

    public function store(Request $request)
    {

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


        if (User:: where('email', '=', $request->email)->orWhere('cpf', '=', $request->cpf)->exists())
            return response()->json(['message' => 'Usuário já foi cadastrado!']);

        $user = User:: create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'empresa' => $request->empresa,
            'password' => Hash:: make($request->password),
            'active' => false,
            'telefone' => $request->telefone,
            'perfil_id' => 4
        ]);

        $tokenAcess = TokenAccess:: create([
            'user_id' => $user->id,
            'tipo' => 'ACTIVE',
            'token' => Str:: random(254),
            'validade' => Carbon:: now()->addMinutes(10)
        ]);

        Log::channel('db')->info(
            'Criado usuario' . $user->id . ' com usuario ' . $user->nome . ' e previlégios ' . $user->perfil->role);

        EnviarEmail:: dispatch($user, $tokenAcess, 'CHECK');
    }


    public function show($id)
    {
        $request = new Request([
            'id' => $id
        ]);
        $validator = Validator::make($request->all(), [
            'id' => 'bail|numeric'
        ],
            [
                'id.numeric' => 'Id inválido!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        return User::with('perfil')->findOrFail($id);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        if($request['nome'] == "all")
            return DB::table('users')->paginate(20);

        if (Str::length($request->nome) > 2)
            return User::where('nome', 'LIKE', '%' . $request->nome . '%')
                ->orWhere('email', 'LIKE', '%' . $request->nome . '%')
                ->orWhere('cpf', 'LIKE', '%' . $request->nome . '%')
                ->orWhere('empresa', 'LIKE', '%' . $request->nome . '%')
                ->simplePaginate(20);
        return response()->json(['message' => 'Necessário ao menos 3 caracteres!'], 201);
    }

    public function edit(Request $request)
    {
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
            $userAuth = auth()->user();

            if ($userAuth->perfil->role !== 'ROOT' && $userAuth->perfil->role !== 'ADMIN')
                if ($userAuth->id !== $request->id)
                    return response()->json(['errors' => 'Operação não permitida!', 'status' => 403], 403);

            $userDB = User::firstWhere('id', $request->id)
                ->update([
                    'nome' => $request->email,
                    'nome' => $request->nome,
                    'cpf' => $request->cpf,
                    'empresa' => $request->empresa,
                    'telefone' => $request->telefone]);

            Log::channel('db')->info(
                'Editado usuario' . $request->email . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'status' => 200], 200);

        } catch (Throwable $e) {
            return response()->json(['error' => 'Falha ao atualizar cadastro!']);
        }
    }

    public function destroy($id)
    {

        try {
            $token = JWTAuth:: parseToken();
            $userAuth = $token->authenticate();

            if ($userAuth->perfil->role === 'ROOT') {
                User::destroy($id);
                Log::channel('db')->info(
                    'Delete usuario' . $id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);
            } else {
                Log::channel('db')->info(
                    'Delete não conlcuido usuario' . $id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);
            }

        } catch (Throwable $e) {
            return response()->json(['error' => 'Falha ao remover cadastro!']);
        }

    }

    public function update(Request $request)
    {
        $userAuth = auth()->user();

        $validator = Validator::make($request->all(), [
            'perfil.id' => 'bail|required',
            'id' => 'bail|required'
        ],
            [
                'perfil.id.required' => 'Id do perfil é obrigatório!',
                'id.required' => 'O id de usuário é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        if($request['perfil.id'] === 1000 )
            return response()->json(['errors' => 'Operação não permitida', 'status' => 403], 403);

        if($userAuth->perfil->id === 4 )
            return response()->json(['errors' => 'Operação não permitida', 'status' => 403], 403);

        User::with('perfil')
            ->findOrFail( $request->id)
            ->update([
                'perfil_id' => $request['perfil.id']
            ]);

        Log::channel('db')->info(
            'Pefil de usuario alterado ' . $request->id . ' com usuario ' . $userAuth->nome . ' e previlégios ' . $userAuth->perfil->nome);

    }


    public function active($id)
    {
        $userAuth = auth()->user();

        if($userAuth->perfil->id !== 1000 && $userAuth->perfil->id !== 2)
            return response()->json(['errors' => 'Operação não permitida', 'status' => 403], 403);

        $active = $this->show($id)->active ? false : true;

        User::findOrFail( $id)
            ->update([
                'active' => $active
            ]);

        Log::channel('db')->info(
            'Alterado status de usuario ' .$active. ' ' . $id . ' com usuario ' . $userAuth->nome . ' e previlégios ' .$userAuth->perfil->nome);

        return response()->json(['active' => $active, 'status' => 200], 200);
    }
}
