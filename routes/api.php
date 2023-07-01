<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogoController; 
use App\Http\Controllers\SecurityController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::get('/email', [UserController::class, 'show']);
Route::get('/catalogo', [CatalogoController::class, 'index']);  


//Users 
Route::post('/user', [UserController::class, 'store']); 
Route::patch('/user', [UserController::class, 'edit']);
Route::delete('/user/{', [UserController::class, 'destroy']); 
  
// Account active and passwords
Route::post('/forgot', [SecurityController::class, 'forgot']); 
Route::post('/forgot/resend', [SecurityController::class, 'resend']); 
Route::put('/forgot/reset/password', [SecurityController::class, 'reset']);


Route::group([ 
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});

 
Route::group([ 
    'middleware' => 'JWT:ADMIN,GUEST',
    'prefix' => 'user',
    'roles' => ['ADMIN', 'GUEST']

], function ($router) {

    Route::get('/{id}', [UserController::class, 'show']); 

});


 
 

 


