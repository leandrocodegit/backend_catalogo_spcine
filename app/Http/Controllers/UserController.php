<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'password' => 'required',
            'perfil' => 'required'
        ]);

        if (User::where('email', '=', $request->email)->exists())
            return response()->json(['message' => 'Email já foi cadastrado!']);     

            return User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'perfil_id' => $request->input('perfil.id')
            ]);    
    }

 
    public function show($id)
    {

        if (User::where('id', '=', $id)->exists())
            return User::find($id)->with('perfil')->find($id); 

       return response()->json(['message' => 'Usuário não encontrado']); 
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
