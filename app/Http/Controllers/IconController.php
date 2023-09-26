<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Icon;
use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IconController extends Controller
{
    public function list()
    {
        return Icon::orderBy('descricao')->get();;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'bail|required'
        ],
            [
                'descricao.required' => 'Descrição é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $mensagem = "Icone criado com sucesso!";
        $isPresentFile = (isset($request['file']) && $request->hasFile('file'));

        if (isset($request['id'])) {
            $iconDB = $this->show($request->id);

            if ($isPresentFile) {
                if (Storage::disk('public')->exists($iconDB->imagem))
                    Storage::disk('public')->delete($iconDB->imagem);
            }

            $mensagem = "Icone atualizado com sucesso!";

            Icon::updateOrCreate(
                ['id' => isset($request['id']) ? $request->id : null], [
                'descricao' => isset($request['descricao']) ? $request->descricao : $iconDB->descricao,
                'imagem' => $isPresentFile ? '/icons/' . $request->file->hashName() : $iconDB->imagem
            ]);
        } else {
            Icon::create([
                'descricao' => $request->descricao,
                'imagem' => $isPresentFile ? '/icons/' . $request->file->hashName() : "/default/icon_default.png"
            ]);
        }

        if ($isPresentFile)
            $file = $request->file->store('icons', 'public');

        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);
    }

    public function show($id)
    {
        return Icon::findOrFail($id);
    }

    public function destroy($id)
    {

        if ($id == 1)
            return response()->json([
                'message' => 'Não é possivel remover o icone padrão!',
                'status' => 400], 400);

        $iconDB = Icon::findOrFail($id);


        if (!(Str::contains($iconDB->imagem, 'defaul')))
            if ($iconDB->imagem != null && Storage::disk('public')->exists($iconDB->imagem))
                Storage::disk('public')->delete($iconDB->imagem);

        $iconDB->delete();

        return response()->json([
            'message' => 'Icone removido com sucesso!',
            'status' => 200], 200);
    }


    public function associar(Request $request)
    {

        Catalogo::findOrFail($request->catalogo_id)
            ->icon()
            ->associate(Icon::findOrFail($request->icon_id))
            ->save();
        return response()->json([
            'message' => 'Icone associado com sucesso!',
            'status' => 200], 200);
    }
}
