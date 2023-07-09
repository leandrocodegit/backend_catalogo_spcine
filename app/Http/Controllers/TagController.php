<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo\Tag;
use App\Models\Catalogo\CategoriaTag; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
 
    public function index()
    {
        //
    }
 
    public function list()
    {
        return Tag::with('categoria')->get();
    }
 
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required',
            'categoria_tag_id' => 'bail|required' 
          ],
          [
            'nome.required' => 'Nome é obrigatório!',
            'categoria_tag_id.required' => 'Categoria é obrigatório!'  
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
 
       $tag = Tag::updateOrCreate(
        [ 'id' => isset($request['id']) ? $request->id : null],[
            'nome' => $request->nome,
            "categoria_tag_id" => $request->categoria_tag_id
        ]); 
         
        return $this->find($tag->id);
    }
 
    public function find($id)
    {
        return Tag::with('categoria')
        ->findOrFail($id);
    }
 
 
 
    public function destroy($id)
    {
        Tag::findOrFail($id)
        ->delete();
        return response()->json([
            'message' => 'Tag removida com sucesso!',
             'status' => 200], 200);   
    }
}
