<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IconController extends Controller
{
    public function list()
    {
        return Icon::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'bail|required',
            'file' => 'bail|required'
        ],
            [
                'descricao.required' => 'Descrição é obrigatório!',
                'file.required' => 'Imagem é obrigatória!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        $icon = Icon::create([
            'descricao' => $request->descricao,
            'imagem' => '/icons/' . $request->file->hashName()
        ]);

        $file = $request->file->store('icons', 'public');
        return $this->show($icon->id);
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
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        $icon = Icon::findOrFail($request->id);

        if ($request->file != null) {
            if (Storage::disk('public')->exists($icon->imagem))
                Storage::disk('public')->delete($icon->imagem);
            $file = $request->file->store('icons', 'public');
        }

        $icon->update([
            'descricao' => $request->descricao == null ? $icon->descricao : $request->descricao,
            'imagem' => $request->file == null ? $icon->url : '/icons/' . $request->file->hashName()
        ]);
        return $this->show($icon->id);
    }

    public function show($id)
    {
        return Icon::findOrFail($id);
    }

    public function destroy($id)
    {
        $iconDB = Icon::findOrFail($id);

            if (Storage::disk('public')->exists($iconDB->imagem))
                Storage::disk('public')->delete($iconDB->imagem);

            $iconDB->delete();

            return response()->json([
                'message' => 'Icon removida com sucesso!',
                'status' => 200], 200);
    }


    public function associar(Request $request){

        Catalogo::findOrFail($request->catalogo_id)
            ->icon()
            ->associate(Icon::findOrFail($request->icon_id))
            ->save();
    }
}
