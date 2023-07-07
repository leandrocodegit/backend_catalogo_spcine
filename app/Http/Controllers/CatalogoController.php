<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Tag;
use App\Models\Catalogo\Preco;
use Symfony\Component\HttpFoundation\Response;
use App\Events\EventResponse;
use Illuminate\Support\Facades\DB;


class CatalogoController extends Controller
{

    public function random(Request $request)
    {        
        return  Catalogo::with('administrador','cordenadas','tags', 'precos', 'imagens', 'regiao', 'regras')
        ->where('home', true) 
        ->where('active', true)
        ->orderByRaw('RAND() LIMIT 15')
        ->get();
    }

    public function filter(Request $request)
    {  
   
   return Catalogo::with('administrador', 'descricoes','cordenadas','tags', 'precos', 'imagens', 'regiao', 'regras')
        ->when($request->orderPrice !== null)      
        ->orderBy('mediaPreco', $request->orderPrice)
        ->when($request->nome !== null)  
        ->where('nome', 'LIKE', '%'. $request->nome .'%') 
        ->when($request->active !== null)  
        ->where('active', $request->active) 
        ->when($request->administrador !== null)
        ->whereHas('administrador',  function ($query) use ($request) {
             $query->whereIn('id', $request->administrador);
        })     
        ->when($request->tags !== null)
        ->whereHas('tags',  function ($query) use ($request) {
             $query->whereIn('id', $request->tags);
        })
        ->when($request->regiao !== null)
        ->whereHas('regiao',  function ($query) use ($request) {
             $query->whereIn('id', $request->regioes);
        })  
        ->when($request->preco !== null)
        ->whereHas('precos',  function ($query) use ($request) {
             $query->where('valor', '>=', $request->preco);
             
        }) 
        ->simplePaginate(20);        
    }

    public function find($id)
    {  
  
        return Catalogo::with('cordenadas','tags', 'precos', 'imagens', 'regiao', 'regras')   
        ->firstWhere('id', $id);

        $preco = Preco::create([
            'descricao' => 'descricao',
            'valor' => 10.1,
            'catalogo_id' => $id,
        ]);
 
        DB::select('CALL `laravel`.`atualiza_media_preco_catalogo`('.$id.')');

        return $preco;
           
    }
 
}
 
