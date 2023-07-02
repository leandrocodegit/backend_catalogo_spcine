<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Tag;
use Symfony\Component\HttpFoundation\Response;

class CatalogoController extends Controller
{
    public function index($nome)
    {
 
        return Tag::where('nome', '=', $nome)->with('catalogos')->get();
    }
 
}
 
