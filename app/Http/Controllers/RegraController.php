<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\RegrasCatalogo;
use App\Models\Catalogo\TipoRegra;
use App\Models\util\MapUtil;
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
            'descricao' => 'bail|required',
            'tipo_id' => 'bail|required'
        ],
            [
                'descricao.required' => 'Descrição é obrigatório!',
                'tipo_id.required' => 'Tipo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        if(TipoRegra::where('id', $request->tipo_id)->exists() == false)
            return response()->json(['errors' => array("Tipo inválido ou removido!"), 'status' => 400], 400);

        $mensagem = "Regra criada com sucesso!";
        $isPresentFile = (isset($request['file']) && $request->hasFile('file'));


        if (isset($request['id']) && Regra::where('id', $request->id)->exists()){
                $regraDB = $this->show($request->id);

            if ($isPresentFile) {
                if (Storage::disk('public')->exists(ENV('APP_URL_REGRAS').$regraDB->imagem))
                    Storage::disk('public')->delete(ENV('APP_URL_REGRAS').$regraDB->imagem);
            }

            $mensagem = "Regra atualizada com sucesso!";

            Regra::updateOrCreate(
                ['id' => isset($request['id']) ? $request->id : null], [
                'descricao' => isset($request['descricao']) ? $request->descricao : $regraDB->descricao,
                'imagem' => $isPresentFile ?   $request->file->hashName() : $regraDB->imagem,
                'tipo_id' => $request->tipo_id
            ]);
        } else {
            Regra::create([
                'descricao' => $request->descricao,
                'imagem' => $isPresentFile ? $request->file->hashName() : "",
                 'tipo_id' => $request->tipo_id
            ]);
        }

        if ($isPresentFile)
            $file = $request->file->store('regras', 'public');

        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);
    }

    public function associar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regra_id' => 'bail|required',
            'catalogo_id' => 'bail|required'
        ],
            [
                'regra_id' => 'Regra é obrigatório!',
                'catalogo_id.required' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' =>  MapUtil::format($validator->messages()), 'status' => 400], 400);

        if(RegrasCatalogo::where('regra_id', $request->regra_id)
            ->where('catalogo_id', $request->catalogo_id)->exists()){
            Catalogo::with('regras')->find($request->catalogo_id)->regras()->detach($request->regra_id);
            return response()->json(['message' => "Regra foi desassociada com sucesso!", 'status' => 200], 200);
        }

        Catalogo::with('regras')->find($request->catalogo_id)->regras()->attach($request->regra_id);
        return response()->json(['message' => "Regra foi associada com sucesso!", 'status' => 200], 200);
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
