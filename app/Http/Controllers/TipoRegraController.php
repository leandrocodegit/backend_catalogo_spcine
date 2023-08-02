<?php

namespace App\Http\Controllers;

use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TipoRegraController extends Controller
{

    public function list()
    {
        return TipoRegra::with('regras')->get();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required'
          ],
          [
            'nome.required' => 'Nome é obrigatório!',
          ]);

          if ($validator->fails())
              return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $mensagem = "Tipo criado com sucesso!";

        if (isset($request['id']))
            $mensagem = "Tipo atualizado com sucesso!";

       $tipo = TipoRegra::updateOrCreate(
        [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome
        ]);

        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);
    }

    public function find($id)
    {
        return TipoRegra::findOrFail($id);
    }



    public function destroy($id)
    {
        TipoRegra::findOrFail($id)
        ->delete();
        return response()->json([
            'message' => 'Tipo de regra removida com sucesso!',
             'status' => 200], 200);
    }
}
