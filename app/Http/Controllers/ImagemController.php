<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use Illuminate\Http\File;
use App\Models\Enums\MessageResponse;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ImagemController extends Controller
{
    public function find($id){
        return Imagem::findOrFail($id);        
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'catalogo_id' => 'bail|required' 
          ],
          [
              'catalogo_id' => 'Catalogo é obrigatório!' 
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
 
        Catalogo::findOrFail($request->catalogo_id); 

        $request->file->store('imagens/' .$request->catalogo_id, 'public'); 
        $imagem = Imagem::where('catalogo_id', $request->catalogo_id)
        ->orderByRaw('ordem desc')
        ->get()
        ->first(); 

        $imagem;
        $ordem = 0;
        if($imagem !== null)
           $ordem = $imagem->ordem + 1;
         
        Imagem::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'ordem' => $ordem,
            'principal' => false,
            'url' => 'imagens/' .$request->catalogo_id. '/' .$request->file->hashName(),
            'originalExtension' => $request->file->getClientOriginalExtension(),
            'originalName' => $request->file->getClientOriginalName(),
            'hashName' => $request->file->hashName(),
            'catalogo_id' => $request->catalogo_id         
        ]);

        return response()->json([
            'message' => 'Imagem gravada com sucesso!',
             'status' => 200], 200);

    }

    public function upload(Request $request){

        Imagem::findOrFail($request->id);
        $imagem = Imagem::with('catalogo')
        ->firstWhere('id', $request->id); 

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln($imagem ); 
        if (Storage::disk('public')->exists('imagens/' .$imagem->catalogo->id))
            Storage::disk('public')->delete($imagem->url); 
          
        $request->file->store('imagens/' .$imagem->catalogo->id, 'public');        
        return response()->json([
            'message' => 'Imagem gravada com sucesso!',
             'status' => 200], 200);
    }

    public function destroy($id){
        
        $imagem = Imagem::findOrFail($id);
        Storage::disk('public')->delete($imagem->url);        

        return response()->json([
                'message' => 'Imagem removida com sucesso!',
                 'status' => 200], 200);        
    }

    public function edit(Request $request){
 
        Imagem::findOrFail($request->id)->update([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'ordem' => $request->ordem,
                'principal' => $request->principal
            ]);  

            return response()->json([
                'message' => 'Imagem editada com sucesso!',
                 'status' => 200], 200);  
    }
}
