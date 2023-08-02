<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {

      $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only(['email', 'password']);

        if (!auth()->validate($credentials))
            return response()->json(['error' => 'Unauthorized'], 401);

        if ($token = auth()->setTTL(20)->attempt($credentials))
            return $this->respondWithToken($token);

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->setTTL(20)->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'type' => 'Bearer',
            'validate' => auth()->factory()->getTTL()
        ]);
    }


}
