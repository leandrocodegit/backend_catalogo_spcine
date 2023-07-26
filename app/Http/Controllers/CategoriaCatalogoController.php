<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\CategoriaCaracteristica;
use App\Models\util\MapError;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoriaCatalogoController extends Controller
{


    public function list(){
        return CategoriaCatalogo::all();
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!',
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapError::format($validator->messages()), 'status' => 400], 400);

        $mensagem = "Categoria criada com sucesso!";

        if(isset($request['id']))
            $mensagem = "Categoria atualizada com sucesso!";

        CategoriaCatalogo::updateOrCreate(
            [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome
        ]);

        return response()->json(['message' => $mensagem, 'status' => 200], 200);
    }

    public function find($id){
        return CategoriaCatalogo::findOrfail($id);
    }

    public function edit(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'bail|required',
            'nome' => 'bail|required'
        ],
            [
                'id.required' => 'Id é obrigatório!',
                'nome.required' => 'Nome é obrigatório!',
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapError::format($validator->messages()), 'status' => 400], 400);

        return CategoriaCatalogo::updateOrCreate(
            [ 'id' => isset($request['id']) ? $request->id : null],
            [
                'nome' => $request->nome
            ]);
    }

    public function destroy($id){
        CategoriaCatalogo::findOrfail($id)->delete();
        return response()->json(['message' => "Categoria removida com sucesso!", 'status' => 200], 200);
    }
}
