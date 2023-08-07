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
            'valor' => 'required|numeric|min:10',
            'catalogo_id' => 'bail|required'
        ],
            [
                'valor.required' => 'Valor é obrigatório!',
                'valor.numeric' => 'Valor não é um numero!',
                'valor.min' => 'Valor não pode ser menor que 1!',
                'catalogo_id' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        return  Preco::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'valor' => $request->valor,
            'descricao' =>  $request->descricao,
            'catalogo_id' => $request->catalogo_id,
        ]);
    }

    public function destroy($id)
    {
        if (Preco::where('id', $id)->exists())
            Preco::firstWhere('id', $id)->delete();
    }


}

