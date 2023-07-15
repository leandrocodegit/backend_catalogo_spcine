<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Agenda;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Preco;
use App\Models\Enums\StatusAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{

    public function list()
    {
        return Agenda::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'catalogo.id' => 'bail|required',
            'preco.id' => 'bail|required',
            'data' => 'bail|required'
        ],
            [
                'catalogo.id' => 'Catalogo é obrigatório!',
                'preco.id' => 'Preço é obrigatório!',
                'data' => 'Data é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        $preco = Preco::firstWhere('id', $request['preco.id']);

        if(Agenda::where('catalogo_id', $request['catalogo.id'])
            ->where('data', $request['data'])
            ->where('status', StatusAgenda::PENDENTE->value)
            ->exists())
            return response()->json(['errors' => 'Já existe um agendamento para este catalogo nesta data', 'status' => 400], 400);

      return Agenda::updateOrCreate([
            'catalogo_id' => $request['catalogo.id'],
            'data' => $request['data'],
            'user_id' => auth()->user()->id,
            'valor' => $preco->valor
        ])->with('catalogo', 'user')->first();

      return Agenda::firstWhere('catalogo_id', $agenda->id);
    }

    public function find($id)
    {
        return Agenda::with('catalogo', 'user')->firstWhere('catalogo_id', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
