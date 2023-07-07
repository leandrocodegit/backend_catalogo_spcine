<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo\CategoriaTag;
use Illuminate\Support\Facades\Validator;
use App\Models\Enums\MessageResponse;

class CategoriaTagController extends Controller
{
    
    public function list(){
       return CategoriaTag::with('tags')->get();
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required' 
          ],
          [
              'nome.required' => 'Nome é obrigatório!', 
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
         CategoriaTag::create([
            'nome' => $request->nome
        ]);
        return response()->json(['message' => MessageResponse::SUCCESS_CREATE, 'status' => 200], 200);
     }

     public function find($id){
        $categoria = CategoriaTag::firstWhere('id', $id);
        if($categoria === null)
            return response()->json(['message' => MessageResponse::NOT_FOUND, 'status' => 202], 202);
        return $categoria;
     }

     public function edit(Request $request){
         
    $validator = Validator::make($request->all(), [
        'id' => 'bail|required',
        'nome' => 'bail|required' 
      ],
      [
        'email.required' => 'Id é obrigatório!',
        'nome.required' => 'Nome é obrigatório!', 
      ]);
  
      if ($validator->fails())
          return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        if(CategoriaTag::firstWhere('id', $request->id)->exists()){
            CategoriaTag::firstWhere('id', $request->id)->update([
                'nome' => $request->nome
            ]);        
            return response()->json(['message' => MessageResponse::SUCCESS_UPDATE, 'status' => 200], 200);
     }
     return response()->json(['message' => MessageResponse::NOT_FOUND, 'status' => 202], 202);
    }
}
