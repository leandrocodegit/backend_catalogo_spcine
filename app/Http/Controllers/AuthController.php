<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Mail\ConfirmacaoEmail; 
use App\Jobs\EnviarEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\TokenAccess;


class AuthController extends Controller
{
    
    private $expires = 60000;
     
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
 
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
 
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'expires' => $this->expires
        ]);
    }
 
    public function active($id, $token)
    {
        if (TokenAcess::where('user_id', $id)
        ->where('token', $token)
        ->where('validade', '>=', Carbon::now())
        ->where('active', '=', false)
        ->exists()){

            if ($user = User::find($id)->exists()){
                User::find($id)
                    ->update(['active' => true]);
            }

            TokenAccess::where(['token' => $token])
            ->update(['active' => true]);
            return  $this->view('active-account', ['user' => $user]);       
        }
        return 'Link expirou ou é inválido!'; 
    }
 
 
}