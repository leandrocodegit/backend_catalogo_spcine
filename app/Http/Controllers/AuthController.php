<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;



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
 
        if (!$token = auth()->attempt($credentials)) {
            JWT::fromUser($user,['role' => $user->perfil->role]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
         
        return $this->respondWithToken($token);
    }
 
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
 
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
 
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'expires' => 600000
        ]);
    }

    public static function reset($email)
    { 
        if (User::where('email', '=', $email)->exists()){ 
            return auth()->tokenById(User::where('email', '=', $email)->first()->id); 
        }
        return response()->json(['error' => 'Not found'], 404);
       
    }
}