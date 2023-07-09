<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo\Catalogo;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogo\Regra;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegraController extends Controller
{
    public function list()
    {
        return Regra::with('tipo')->get();
    }
 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_id' => 'bail|required',
            'descricao' => 'bail|required' 
          ],
          [
              'tipo_id.required' => 'O tipo é obrigatório!',
              'descricao.required' => 'Descrição é obrigatório!' 
          ]);
      
          if ($validator->fails())
              return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
        
        if ($request->id !== null)
            if (Regra::where('id', $request->id)->exists()){
                $regraDB = Regra::firstWhere('id', $request->id);
                if (Storage::disk('public')->exists($regraDB->icon))
                    Storage::disk('public')->delete($regraDB->icon); 
            }

        $regra = Regra::updateOrCreate(
            [ 'id' => isset($request['id']) ? $request->id : null],[
                'tipo_id' => $request->tipo_id,
                'descricao' => $request->descricao,
                'icon' => 'regras/' .$request->file->hashName()
            ]);

            $file =$request->file->store('regras', 'public'); 
         return $this->show($regra->id);   

    }
 
    public function show($id)
    {
        return Regra::with('tipo')
        ->findOrFail($id);
    }
 
    public function destroy($id)
    {
        Regra::findOrFail($id)
        ->delete();
        return response()->json([
            'message' => 'Regra removida com sucesso!',
             'status' => 200], 200);   
    }
}
