<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Catalogo;
use App\Models\Enums\StatusAgenda;
use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use App\Models\Catalogo\Caracteristica;
use App\Models\Catalogo\CategoriaCaracteristica;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CaracteristicaController extends Controller
{

    public function associar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caracteristica_id' => 'bail|required',
            'catalogo_id' => 'bail|required'
        ],
            [
                'caracteristica_id' => 'Caracteristica é obrigatório!',
                'catalogo_id.required' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' =>  MapUtil::format($validator->messages()), 'status' => 400], 400);

        Catalogo::with('caracteristicas')->find($request->catalogo_id)->caracteristicas()->attach($request->caracteristica_id);
        return response()->json(['message' => "Tag foi associada com sucesso!", 'status' => 200], 200);
    }

    public function desassociar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caracteristica_id' => 'bail|required',
            'catalogo_id' => 'bail|required'
        ],
            [
                'caracteristica_id' => 'Caracteristica é obrigatório!',
                'catalogo_id.required' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' =>  MapUtil::format($validator->messages()), 'status' => 400], 400);

        Catalogo::with('caracteristicas')->find($request->catalogo_id)->caracteristicas()->detach($request->caracteristica_id);
        return response()->json(['message' => "Tag foi desassociada com sucesso!", 'status' => 200], 200);

    }

    public function list()
    {
        return Caracteristica::all();
    }



    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required',
            'categoria_id' => 'bail|required'
          ],
          [
            'nome.required' => 'Nome é obrigatório!',
            'categoria_id.required' => 'Categoria é obrigatório!'
          ]);

          if ($validator->fails())
              return response()->json(['errors' =>  MapUtil::format($validator->messages()), 'status' => 400], 400);

        $mensagem = "Tag criada com sucesso!";

        if(isset($request['id']))
            $mensagem = "Tag atualizada com sucesso!";

        $caracteristica = Caracteristica::updateOrCreate(
        [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome,
            "categoria_id" => $request->categoria_id
        ]);

        return response()->json(['message' => $mensagem, 'status' => 200], 200);
    }

    public function find($id)
    {
        return Caracteristica::with('categoria')
        ->findOrFail($id);
    }



    public function destroy($id)
    {
        Caracteristica::findOrFail($id)
        ->delete();
        return response()->json([
            'message' => 'Caracteristica removida com sucesso!',
             'status' => 200], 200);
    }
}
