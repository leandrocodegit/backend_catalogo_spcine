<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Administrador;
use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdministradorController extends Controller
{

    public function list(){
       return Administrador::all();
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

        $mensagem = "Administrador criado com sucesso!";

        if(isset($request['id']))
            $mensagem = "Administrador atualizado com sucesso!";

        Administrador::updateOrCreate(
            [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome,
            'active' => isset($request['active']) ?  $request->active : false
        ]);

        return response()->json(['message' => $mensagem, 'status' => 200], 200);
     }

     public function find($id){
         return Administrador::findOrfail($id);
     }

    public function destroy($id){
        Administrador::findOrfail($id)->delete();
        return response()->json(['message' => 'Administrador removido com sucesso!', 'status' => 200], 200);
    }
}
