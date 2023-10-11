<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Imagem;
use App\Models\util\ImagemUtil;
use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImagemController extends Controller
{
    public function find($id)
    {
        return Imagem::findOrFail($id);
    }

    public function findPorCatalogo($id)
    {
        return Imagem::where('catalogo_id', $id)->get();
    }

    public function store(Request $request)
    {

        echo json_encode($request);
        echo "\n";
        $validator = Validator::make($request->all(), [
            'catalogo_id' => 'bail|required',
        ],
            [
                'catalogo_id' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        Catalogo::findOrFail($request->catalogo_id);

        $isPresentFile = $request->hasFile('file');

        if ($isPresentFile) {
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image',
                'file' => 'max:8048'
            ],
                [
                    'image' => 'Formato de arquivo inválido',
                    'file.max' => 'O arquivo deve ser menor que 8mb'
                ]);

            if ($validator->fails())
                return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);
        }


        if ($isPresentFile)
            $request->file->store('imagens/' . $request->catalogo_id, 'public');

        $imagemDB = null;

        if (isset($request['id']))
            $imagemDB = Imagem::firstWhere('id', $request->id);

        $mensagem = "Imagem criado com sucesso!";
        if (isset($request['id']))
            $mensagem = "Imagem atualizado com sucesso!";

        if ($isPresentFile && $imagemDB != null)
            if (Storage::disk('public')->exists('imagens/' . $imagemDB->url))
                Storage::disk('public')->delete('imagens/' . $imagemDB->url);

        if ($request->principal)
            Imagem::where('catalogo_id', $request->catalogo_id)->update([
                'principal' => false
            ]);

        $imagemSalva = Imagem::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'titulo' => $request->titulo == null ? "" : $request->titulo,
            'descricao' => $request->descricao == null ? "" : $request->descricao,
            'ordem' => 0,
            'principal' => $request->principal == null ? false : $request->principal,
            'catalogo_id' => $request->catalogo_id
        ]);

        if ($isPresentFile) {
            $imagemSalva->url = $request->catalogo_id . '/' . $request->file->hashName();
            $imagemSalva->save();
        }

        if(!str_contains($imagemSalva->url, '.webp'))
            ImagemUtil::convert($imagemSalva);

        Log::channel('db')->info(
            'Criado imagem catalogo ' . $request->catalogo_id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);

    }

    public function destroy($id)
    {

        Log::channel('db')->info(
            'Delete imagem ' . $id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        $imagem = Imagem::findOrFail($id);
        if (Storage::disk('public')->exists('imagens/' . $imagem->url))
            Storage::disk('public')->delete('imagens/' . $imagem->url);

        $imagem->delete();

        return response()->json([
            'message' => 'Imagem removida com sucesso!',
            'status' => 200], 200);
    }

    public function edit(Request $request)
    {

        Log::channel('db')->info(
            'Editado imagem ' . $request->id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        Imagem::findOrFail($request->id)->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'ordem' => $request->ordem,
            'principal' => $request->principal
        ]);

        return response()->json([
            'message' => 'Imagem editada com sucesso!',
            'status' => 200], 200);
    }
}
