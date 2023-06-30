<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogoController; 

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
Route::post('/user', [UserController::class, 'store']); 
Route::post('/forgot', [UserController::class, 'forgot']); 
  

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


 
 

 


