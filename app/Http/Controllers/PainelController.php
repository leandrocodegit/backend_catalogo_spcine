<?php

namespace App\Http\Controllers;

use App\Models\Account\User;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Agenda;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\CategoriaCaracteristica;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Regra;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Http\Request;

class PainelController extends Controller
{

    public function dash(){

        return response()->json([
            'agendas' => Agenda::all()->count(),
            'catalogos' => Catalogo::all()->count(),
            'usuarios' => User::all()->count() - 1,

        ], 200);
    }

}
