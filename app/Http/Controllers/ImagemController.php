<?php

namespace App\Http\Controllers;

use App\Models\util\ImagemUtil;
use App\Models\util\MapUtil;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use Illuminate\Http\File;
use App\Models\Enums\MessageResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class ImagemController extends Controller
{
    public function find($id)
    {
        return Imagem::findOrFail($id);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'catalogo_id' => 'bail|required'
        ],
            [
                'catalogo_id' => 'Catalogo é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        Catalogo::findOrFail($request->catalogo_id);

        $mensagem = "Imagem criado com sucesso!";
        $isPresentFile = (isset($request['file']) && $request->hasFile('file'));

        if ($isPresentFile)
            $request->file->store('imagens/' . $request->catalogo_id, 'public');

        $imagem = Imagem::where('catalogo_id', $request->catalogo_id)
            ->orderByRaw('ordem desc')
            ->get()
            ->first();

        if (isset($request['id']))
            $mensagem = "Imagem atualizado com sucesso!";

        $imagem;
        $ordem = 0;
        if ($imagem !== null) {
            $ordem = $imagem->ordem + 1;

            if ($isPresentFile) {
                if (Storage::disk('public')->exists('imagens/' .$imagem->url))
                    Storage::disk('public')->delete('imagens/' .$imagem->url);
            }
        }

        $imagemDB = null;

        if(isset($request['id']))
        $imagemDB = Imagem::firstWhere('id', $request->id);

        Imagem::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'ordem' => $ordem,
            'principal' => false,
            'url' => $isPresentFile ?   $request->catalogo_id . '/' . $request->file->hashName() : ($imagemDB != null ? $imagem->url : ''),
            'catalogo_id' => $request->catalogo_id
        ]);

        Log::channel('db')->info(
            'Criado imagem catalogo ' . $request->catalogo_id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);


        if($isPresentFile)
            ImagemUtil::convert($imagem);


        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);

    }

    public function destroy($id)
    {

        Log::channel('db')->info(
            'Delete imagem ' . $id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        $imagem = Imagem::findOrFail($id);
        Storage::disk('public')->delete($imagem->url);

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
