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
        $categoriasCatalogo = CategoriaCatalogo::all();
        $regioes = Regiao::all();
        $tipos = TipoRegra::with('regras')->get();
        $administrador = Administrador::all();
        $menorPreco = Preco::min('minimo');
        $maiorPreco = Preco::max('maximo');

        return response()->json([
            'categoriaCaracteristicas' => $categoriaCaracteristicas,
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

    public function count(Request $request)
    {
        $categoriaCaracteristicas = CategoriaCaracteristica::with('caracteristicas')->get();
        $tipos = TipoRegra::with('regras')->get();
        $menorPreco = Preco::min('minimo');
        $maiorPreco = Preco::max('maximo');

        $controller = new CatalogoController();
        $catalogosFilter = $controller->buscar($request);

        $catalogos = $catalogosFilter->get()->map(function ($item) {
            return $item->id;
        });


        $regioes = Regiao::join('catalogos as ca', 'regiao_id', '=', 'regioes.id')->wherein('ca.id', $catalogos)
            ->select('regioes.*', DB::raw('COUNT(regioes.id) as catalogos_count'))
            ->groupBy('regioes.id')
            ->get();

        $administrador = Administrador::join('catalogos as ca', 'regiao_id', '=', 'administrador_catalogo.id')
            ->wherein('ca.id', $catalogos)
            ->select('administrador_catalogo.*', DB::raw('COUNT(administrador_catalogo.id) as catalogos_count'))
            ->groupBy('administrador_catalogo.id')
            ->get();

        $categoriasCatalogo = CategoriaCatalogo::join('catalogos as ca', 'categoria_id', '=', 'categoria_catalogo.id')
            ->wherein('ca.id', $catalogos)
            ->select('categoria_catalogo.*', DB::raw('COUNT(categoria_catalogo.id) as catalogos_count'))
            ->groupBy('categoria_catalogo.id')
            ->get();


        foreach ($categoriaCaracteristicas as $categoria) {
            foreach ($categoria->caracteristicas as $caracterisitca) {
                $caracterisitca->catalogos_count = CaracteristicasCatalogo::where('caracteristica_id', $caracterisitca->id)
                    ->whereIn('catalogo_id', $catalogos)
                    ->count();
            }

            foreach ($tipos as $tipo) {
                foreach ($tipo->regras as $regra) {
                    $regra->catalogos_count = RegrasCatalogo::where('regra_id', $regra->id)
                        ->whereIn('catalogo_id', $catalogos)
                        ->count();
                }
            }

            return response()->json([
                'regioes' => $regioes,
                'administrador' => $administrador,
                'categoriasCatalogo' => $categoriasCatalogo,
                'categoriaCaracteristicas' => $categoriaCaracteristicas,
                'tipos' => $tipos,
                'preco' => [
                    'menor' => $menorPreco,
                    'maior' => $maiorPreco
                ]


            ], 200);
        }
    }
}
