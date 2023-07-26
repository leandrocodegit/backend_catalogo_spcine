<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\CategoriaCaracteristica;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Regra;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Http\Request;

class FiltroController extends Controller
{

    public function filtro()
    {
        $categoriaCaracteristicas = CategoriaCaracteristica::with('caracteristicas')->get();
        $categoriasCatalogo = CategoriaCatalogo::all();
        $regioes = Regiao::all();
        $tipos = TipoRegra::with('regras')->get();
        $administrador = Administrador::all();
        $menorPreco = Preco::min('valor');
        $maiorPreco = Preco::max('valor');

        return response()->json([
            'categoriasTag' => [$categoriaCaracteristicas],
            'categoriasCatalogo' => $categoriasCatalogo,
            'regioes' => $regioes,
            'tipos' => $tipos,
            'administrador' => $administrador,
            'preco' => [
                    'menor' => $menorPreco,
                    'maior' => $maiorPreco
                ]

        ], 200);
    }

}
