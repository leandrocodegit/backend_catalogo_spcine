<?php

namespace App\Http\Controllers;

use App\Models\util\MapError;
use Illuminate\Http\Request;
use App\Models\Catalogo\Catalogo;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogo\Regra;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegraController extends Controller
{
    public function list()
    {
        return Regra::with('tipo')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_id' => 'bail|required',
            'descricao' => 'bail|required'
        ],
            [
                'tipo_id.required' => 'O tipo é obrigatório!',
                'descricao.required' => 'Descrição é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapError::format($validator->messages()), 'status' => 400], 400);

        $regra = Regra::create([
            'tipo_id' => $request->tipo_id,
            'descricao' => $request->descricao,
            'imagem' => '/regras/' . $request->file->hashName()
        ]);

        $request->file->store('regras', 'public');

        return $this->show($regra->id);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'bail|required'
        ],
            [
                'id.required' => 'Id é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapError::format($validator->messages()), 'status' => 400], 400);

        $regra = Regra::with('tipo')->findOrFail($request->id);

        if ($request->file != null) {
            if (Storage::disk('public')->exists($regra->imagem))
                Storage::disk('public')->delete($regra->imagem);
            $request->file->store('regras', 'public');
        }

        $regra->update([
            'descricao' => $request->descricao == null ? $regra->descricao : $request->descricao,
            'tipo_id' => $request->tipo_id == null ? $regra->tipo->id : $request->tipo_id,
            'imagem' => $request->file == null ? $regra->imagem : '/regras/' . $request->file->hashName()
        ]);
        return $this->show($regra->id);
    }

    public function show($id)
    {
        return Regra::with('tipo')
            ->findOrFail($id);
    }

    public function destroy($id)
    {

        $regraDB = Regra::findOrFail($id);

            if (Storage::disk('public')->exists($regraDB->imagem))
                Storage::disk('public')->delete($regraDB->imagem);

            $regraDB->delete();

            return response()->json([
                'message' => 'Regra removida com sucesso!',
                'status' => 200], 200);
    }
}
