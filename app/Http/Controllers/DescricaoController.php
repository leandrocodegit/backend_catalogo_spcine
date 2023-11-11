<?php

namespace App\Http\Controllers;

use App\Events\EventResponse;
use App\Models\Catalogo\Descricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DescricaoController extends Controller
{

    public function findPorCatalogo($id)
    {
        return Descricao::where('catalogo_id',$id)->get();
    }
    public function store(Request $request)
    {

        $mensagem = "Descrição criada com sucesso!";

        if (isset($request['id']) && Descricao::where('id', $request->id)->exists()){
            $mensagem = "Descrição atualizada com sucesso!";
            Log::channel('db')->info(
                'Atualizado descrição ' . $request['id'] . ' ' . substr($request->descricao, 50) . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
        }
        else{
            Log::channel('db')->info(
                'Adicionado nova descrição para catalogo ' . $request->catalogo_id . ' ' . substr($request->descricao, 50) . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
        }

      Descricao::updateOrCreate(
            ['id' => isset($request['id']) ? $request->id : null], [
            'titulo' => $request->titulo,
            'descricao' =>  $request->descricao,
            'destaque' => $request->destaque,
            'catalogo_id' => $request->catalogo_id,
        ]);

        return response()->json([
            'message' => $mensagem,
            'status' => 200], 200);
    }

    public function destaque($id)
    {
        $descricaoDB = Descricao::firstWhere('id', $id);
        $descricaoDB->destaque = $descricaoDB->destaque ? false : true;
        $descricaoDB->save();
        Log::channel('db')->info(
            'Editado destaque descrição ' . $id . ' ' . $descricaoDB->destaque ? "SIM" : "NÃO" . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);

        return $descricaoDB->destaque;
    }

    public function destroy($id)
    {
        if (Descricao::where('id', $id)->exists())
            Descricao::firstWhere('id', $id)->delete();

        Log::channel('db')->info(
            'Removido descrição ' . $id . ' ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
    }


}

