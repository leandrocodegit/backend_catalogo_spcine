<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\CategoriaTag;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Regra;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Http\Request;

class FiltroController extends Controller
{

    public function filtro()
    {
        $categorias = CategoriaTag::with('tags')->get();
        $regras = TipoRegra::with('regras')->get();
        $administrador = Administrador::all();
        $menorPreco = Preco::min('valor');
        $maiorPreco = Preco::max('valor');

        return response()->json([
            'categorias' => $categorias,
            'regras' => $regras,
            'administrador' => $administrador,
            'preco' => [
                    'menor' => $menorPreco,
                    'maior' => $maiorPreco
                ]

        ], 400);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
