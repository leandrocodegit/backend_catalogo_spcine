<?php

namespace App\Http\Controllers;

use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use App\Models\Catalogo\CategoriaCaracteristica;
use Illuminate\Support\Facades\Validator;

class CategoriaCaracteristicaController extends Controller
{

    public function list(){
       return CategoriaCaracteristica::orderBy('nome')->with('caracteristicas')->get();
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required'
          ],
          [
              'nome.required' => 'Nome é obrigatório!',
          ]);

          if ($validator->fails())
              return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $mensagem = "Categoria criada com sucesso!";

        if(isset($request['id']))
            $mensagem = "Categoria atualizada com sucesso!";

        CategoriaCaracteristica::updateOrCreate(
            [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome
        ]);

        return response()->json(['message' => $mensagem, 'status' => 200], 200);
     }

     public function find($id){
         return CategoriaCaracteristica::findOrfail($id);
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
          return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

           return CategoriaCaracteristica::updateOrCreate(
                [ 'id' => isset($request['id']) ? $request->id : null],
                [
                'nome' => $request->nome
            ]);
    }

    public function destroy($id){
        return CategoriaCaracteristica::findOrfail($id)->delete();
    }
}
