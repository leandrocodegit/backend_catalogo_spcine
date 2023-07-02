<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Tag;
use Symfony\Component\HttpFoundation\Response;

class CatalogoController extends Controller
{
    public function filter(Request $request)
    {  
 
        return Catalogo::query()
        ->with('tags', 'precos', 'imagens', 'regiao', 'regras')
        ->whereHas('tags',  function ($query) use ($request) {
            return $query->whereIn('id', $request->tags);
        })
        ->whereHas('regiao',  function ($query) use ($request) {
            return $query->whereIn('id', $request->regioes);
        })  
        ->whereHas('precos',  function ($query) use ($request) {
            $query->orderBy('valor', 'desc');
            $query->where('valor', '>=', $request->preco);
        }) 
        ->simplePaginate(20)
        ->sortBy('valor');

        if($request->orderPreco !== null){
            if($request->orderPreco !== null && $request->orderPreco === 'MENOR'){
        return Catalogo::query()
        ->with('tags', 'precos', 'imagens', 'regiao', 'regras')
        ->whereHas('tags',  function ($query) use ($request) {
            return $query->whereIn('id', $request->tags);
        })
        ->whereHas('regiao',  function ($query) use ($request) {
            return $query->whereIn('id', $request->regioes);
        })  
        ->whereHas('precos',  function ($query) use ($request) {
            return $query->where('valor', '>=', $request->preco)->orderBy("valor", "desc");
        }) 
        ->simplePaginate(20);
    }
    if($request->orderPreco !== null && $request->orderPreco === 'MAIOR'){
        return Catalogo::query()
        ->with('tags', 'precos', 'imagens', 'regiao', 'regras')
        ->whereHas('tags',  function ($query) use ($request) {
            return $query->whereIn('id', $request->tags);
        })
        ->whereHas('regiao',  function ($query) use ($request) {
            return $query->whereIn('id', $request->regioes);
        })  
        ->whereHas('precos',  function ($query) use ($request) {
            return $query->where('valor', '>=', $request->preco)->orderBy("valor", "asc");
        }) 
        ->simplePaginate(20);
    }
    }

    return Catalogo::query()
        ->with('tags', 'precos', 'imagens', 'regiao', 'regras')
        ->whereHas('tags',  function ($query) use ($request) {
            return $query->whereIn('id', $request->tags);
        })
        ->whereHas('regiao',  function ($query) use ($request) {
            return $query->whereIn('id', $request->regioes);
        })  
        ->whereHas('precos',  function ($query) use ($request) {
            return $query->where('valor', '>=', $request->preco);
        }) 
        ->simplePaginate(20);

    }
 
}
 
