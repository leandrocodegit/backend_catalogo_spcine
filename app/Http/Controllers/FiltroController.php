<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Caracteristica;
use App\Models\Catalogo\CaracteristicasCatalogo;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\CategoriaCaracteristica;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Regra;
use App\Models\Catalogo\RegrasCatalogo;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Aws\filter;

class FiltroController extends Controller
{

    public function filtro()
    {
        $categoriaCaracteristicas = CategoriaCaracteristica::with('caracteristicas')->get();
        $categoriasCatalogo = CategoriaCatalogo::orderBy('nome')->get();
        $regioes = Regiao::orderBy('nome')->get();
        $tipos = TipoRegra::with('regras')->get();
        $administrador = Administrador::all();
        $menorPreco = Preco::min('minimo');
        $maiorPreco = Preco::max('maximo');

        return response()->json([
            'categoriaCaracteristicas' => $categoriaCaracteristicas,
            'categoriasCatalogo' => collect($categoriasCatalogo)->sortBy('count', SORT_ASC, true)->values()->all(),
            'regioes' => collect($regioes)->sortBy('count', SORT_ASC, true)->values()->all(),
            'tipos' => $tipos,
            'administrador' => collect($administrador)->sortBy('count', SORT_ASC, true)->values()->all(),
            'preco' => [
                'menor' => $menorPreco,
                'maior' => $maiorPreco
            ]

        ], 200);
    }

}
