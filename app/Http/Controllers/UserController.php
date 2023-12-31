<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarEmail;
use App\Models\Account\TokenAccess;
use App\Models\Account\User;
use App\Models\util\MapUtil;
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

    public function list(){
        return User::all();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required',
            'email' => 'bail|required|email',
            // 'documento' => 'bail|required',
            // 'empresa' => 'bail|required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase(1)->symbols(1)->numbers(1)],
            //'telefone' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!',
                'email.required' => 'Email é obrigatório!',
                'email.email' => 'Email não é válido!',
                //   'documento.required' => 'Documento é obrigatório!',
                //   'empresa.required' => 'Empresa é obrigatório!',
                //'telefone.required' => 'Telefone é obrigatório!',
                'password.required' => 'Senha é obrigatório!',
                'password_confirmation.required' => 'Confirmação de senha é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);


        if (User:: where('email', '=', $request->email)->exists())
            return response()->json(['message' => 'Usuário já foi cadastrado!'], 422);

        $user = User:: create([
            'nome' => $request->nome,
            'email' => $request->email,
            'documento' => $request->documento,
            //  'empresa' => $request->empresa,
            'password' => Hash:: make($request->password),
            'active' => false,
            'telefone' => $request->telefone,
            'celular' => $request->celular,
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

        return response()->json(['message' => 'Usuário cadastrado com sucesso!'], 200);
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
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

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
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        if ($request['nome'] == "all")
            return User::with('perfil')->where('nome', '!=', 'Root')->paginate(50);

        if (Str::length($request->nome) > 2)
            return User::with('perfil')
                ->where('nome', 'LIKE', '%' . $request->nome . '%')
                ->orWhere('email', 'LIKE', '%' . $request->nome . '%')
                ->orWhere('documento', 'LIKE', '%' . $request->nome . '%')
                ->orWhere('empresa', 'LIKE', '%' . $request->nome . '%')
                ->where('nome', '!=', 'Root')
                ->simplePaginate(50);
        return response()->json(['message' => 'Necessário ao menos 3 caracteres!'], 201);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required',
            'email' => 'bail|required',
            //    'documento' => 'bail|required',
           // 'empresa' => 'bail|required',
            'telefone' => 'bail|required',
            'celular' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!',
                'email.required' => 'Email é obrigatório!',
                //    'documento.required' => 'Documento é obrigatório!',
                //    'empresa.required' => 'Empresa é obrigatório!',
                'telefone.required' => 'Telefone é obrigatório!',
                'celular.required' => 'Celular é obrigatório!',
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        try {
            $userAuth = auth()->user();

            if ($userAuth->perfil->role !== 'ROOT' && $userAuth->perfil->role !== 'ADMIN')
                if ($userAuth->id !== $request->id)
                    return response()->json(['errors' => 'Operação não permitida!', 'status' => 403], 403);

            $userDB = User::firstWhere('id', $request->id)
                ->update([
                    'email' => $request->email,
                    'nome' => $request->nome,
                    //    'documento' => $request->documento,
                    //    'empresa' => $request->empresa,
                    'telefone' => $request->telefone,
                    'celular' => $request->celular,
                ]);

            Log::channel('db')->info(
                'Editado usuario' . $request->email . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'status' => 200], 200);

        } catch (Throwable $e) {
            if ($e->getCode() === "23000")
                return response()->json(['message' => 'Email ou documento já existe!', 'status' => 422], 422);
            return response()->json(['message' => 'Falha ao atualizar cadastro!' . $e->getCode(), 'status' => 422], 422);
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
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        if ($request['perfil.id'] === 1000)
            return response()->json(['errors' => 'Operação não permitida', 'status' => 403], 403);

        if ($userAuth->perfil->id === 4)
            return response()->json(['errors' => 'Operação não permitida', 'status' => 403], 403);

        User::with('perfil')
            ->findOrFail($request->id)
            ->update([
                'perfil_id' => $request['perfil.id']
            ]);

        Log::channel('db')->info(
            'Pefil de usuario alterado ' . $request->id . ' com usuario ' . $userAuth->nome . ' e previlégios ' . $userAuth->perfil->nome);

    }


    public function active($id)
    {
        $userAuth = auth()->user();

        if ($userAuth->perfil->id !== 1000 && $userAuth->perfil->id !== 2)
            return response()->json(['errors' => 'Operação não permitida', 'status' => 403], 403);

        $active = $this->show($id)->active ? false : true;

        User::findOrFail($id)
            ->update([
                'active' => $active
            ]);

        Log::channel('db')->info(
            'Alterado status de usuario ' . $active . ' ' . $id . ' com usuario ' . $userAuth->nome . ' e previlégios ' . $userAuth->perfil->nome);

        return response()->json(['message' => $active ? "Usuário ativado!" : "Usuário foi desativado!", 'status' => 200], 200);
    }



}
