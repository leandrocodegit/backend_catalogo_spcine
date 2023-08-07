<?php

namespace App\Http\Controllers;

use App\Events\EventResponse;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PerfilController extends Controller
{

    public function list()
    {
        return PerfilUsuario::where('role', '!=', 'ROOT')->get();
    }

    public function alter(Request $request)
    {

        if($request->perfil_id === 1000)
            return response()->json(['message' => "Operação não permitida!", 'status' => 400], 400);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'perfil_id' => 'required'
        ],
            [
                'user_id.required' => 'Id do usuário é obrigatório!',
                'perfil_id.required' => 'Id do perfil é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $user = User::findOrFail($request->user_id);

        if(!$user->active)
            return response()->json(['message' => "Não é possivel alterar perfil de usuário inativo!", 'status' => 400], 400);

        $user->update([
            'perfil_id' => $request->perfil_id
        ]);

        return response()->json(['message' => "Perfil foi alterado com sucesso!", 'status' => 200], 200);
    }


}

