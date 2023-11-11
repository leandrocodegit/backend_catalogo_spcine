<?php

namespace App\Http\Controllers;
use App\Models\Catalogo\Preco;
use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PrecoController extends Controller
{

    public function findPorCatalogo($id)
    {
        return Preco::where('catalogo_id',$id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'minimo' => 'required|numeric|min:0',
            'maximo' => 'required|numeric|min:0',
            'catalogo_id' => 'bail|required'
        ],
            [
                'minimo.required' => 'Valor é obrigatório!',
                'minimo.numeric' => 'Valor não é um numero!',
                'minimo.min' => 'Valor não pode ser menor que 1!',
                'maximo.required' => 'Valor é obrigatório!',
                'maximo.numeric' => 'Valor não é um numero!',
                'maximo.min' => 'Valor não pode ser menor que 1!',
                'catalogo_id' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $mensagem = "Preço criado com sucesso!";

        if (isset($request['id']) && Preco::where('id', $request->id)->exists()){
            $mensagem = "Preço atualizado com sucesso!";
            Log::channel('db')->info(
                'Atualizado preço ' . $request['id'] . ' ' . $request->minimo . ' ' .  $request->maximo . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
        }
        else{
            Log::channel('db')->info(
                'Criado novo preço para catalogo ' . $request->catalogo_id . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
        }


      $preco =  Preco::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'minimo' => $request->minimo,
            'maximo' => $request->maximo,
            'descontos' =>  $request->descontos,
            'tabela_descontos' =>  $request->tabela_descontos,
            'tabela_precos' =>  $request->tabela_precos,
            'descricao' =>  $request->descricao,
            'catalogo_id' => $request->catalogo_id,
        ]);



        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);
    }

    public function destroy($id)
    {
        if (Preco::where('id', $id)->exists()){
           $preco = Preco::firstWhere('id', $id);

           $countCatalogos = Preco::where('catalogo_id', $preco->catalogo_id)->count();
           if($countCatalogos < 2){
               return response()->json([
                   'message' => "Não é possivel remover todos os preços do catalogo!",
                   'status' => 422], 422);
           }
           else{
               $preco->delete();
               Log::channel('db')->info(
                   'Removido preço ' . $id . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
               return response()->json([
                   'message' => 'Preço removido com sucesso!',
                   'status' => 200], 200);
           }
        }

    }


}

