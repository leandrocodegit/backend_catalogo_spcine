<?php

namespace App\Http\Controllers;
use App\Models\Catalogo\Preco;
use App\Models\util\MapUtil;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use Illuminate\Http\File;
use App\Models\Enums\MessageResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class PrecoController extends Controller
{
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

        if (isset($request['id']) && Preco::where('id', $request->id)->exists())
            $mensagem = "Preço atualizado com sucesso!";

        Preco::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'minimo' => $request->minimo,
            'maximo' => $request->maximo,
            'descontos' =>  $request->descontos,
            'tabela_descontos' =>  $request->tabela_descontos,
            'descricao' =>  $request->descricao,
            'catalogo_id' => $request->catalogo_id,
        ]);

        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);
    }

    public function destroy($id)
    {
        if (Preco::where('id', $id)->exists())
            Preco::firstWhere('id', $id)->delete();
    }


}

