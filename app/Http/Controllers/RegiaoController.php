<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Regiao;
use App\Models\util\MapError;
use Illuminate\Http\Request;
use App\Models\Catalogo\CategoriaCaracteristica;
use Illuminate\Support\Facades\Validator;
use App\Models\Enums\MessageResponse;

class RegiaoController extends Controller
{

    public function list(){
       return Regiao::all();
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

        $mensagem = "Região criada com sucesso!";

        if(isset($request['id']))
            $mensagem = "Região atualizada com sucesso!";

        Regiao::updateOrCreate(
            [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome
        ]);

        return response()->json(['message' => $mensagem, 'status' => 200], 200);
     }

     public function find($id){
         return Regiao::findOrfail($id);
     }

    public function destroy($id){
        Regiao::findOrfail($id)->delete();
        return response()->json(['message' => 'Região removida com sucesso!', 'status' => 200], 200);
    }
}
