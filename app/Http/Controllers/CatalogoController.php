<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Imagem;

class CatalogoController extends Controller
{
    public function index()
    {
 
        return Usuario::find(1)->with('perfil')->first();
    }

    public function index2()
    {
        return Imagem::with('catalogo');
    }
}
 
