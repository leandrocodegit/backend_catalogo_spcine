<?php

namespace App\Http\Controllers;

use App\Events\EventResponse;
use App\Models\Catalogo\Descricao;
use Illuminate\Http\Request;


class DescricaoController extends Controller
{

    public function store(Request $request)
    {
      return  Descricao::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'titulo' => $request->titulo,
            'descricao' =>  $request->descricao,
            'catalogo_id' => $request->catalogo_id,
        ]);
    }

    public function destaque($id)
    {
        $descricaoDB = Descricao::firstWhere('id', $id);
        $descricaoDB->destaque = $descricaoDB->destaque ? false : true;
        $descricaoDB->save();
        return $descricaoDB->destaque;
    }

    public function destroy($id)
    {
        if (Descricao::where('id', $id)->exists())
            Descricao::firstWhere('id', $id)->delete();
    }


}

