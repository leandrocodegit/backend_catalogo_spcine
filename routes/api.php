<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogoController; 
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ImagemController;
use App\Http\Controllers\CategoriaTagController; 
use App\Http\Controllers\ExportImportController; 
use App\Http\Controllers\TagController; 

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

//Route:: Tags
Route::group([ 
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'tag',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) { 
    Route::get('/{id}', [TagController::class, 'find']);
    Route::get('/find/list', [TagController::class, 'list']);
    Route::post('/', [TagController::class, 'store']);
    Route::delete('/{id}', [TagController::class, 'destroy']);
});


//Route:: Exports arquivos de relatorio
Route::group([ 
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'data',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/export/catalogo', [ExportImportController::class, 'catalogosXLS']);  
});
Route::group([ 
    'middleware' => 'JWT:ROOT',
    'prefix' => 'data',
    'roles' => ['ROOT']

], function ($router) { 
    Route::post('/import/catalogo', [ExportImportController::class, 'importCatalogo']); 
    Route::post('/import/usuario', [ExportImportController::class, 'importUsers']);
});

//Route:: Imagens upload
Route::group([ 
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'imagem',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) { 
    Route::post('/', [ImagemController::class, 'store']); 
    Route::post('/file', [ImagemController::class, 'upload']); 
    Route::patch('/', [ImagemController::class, 'edit']);  
    Route::get('/{id}', [ImagemController::class, 'find']); 
    Route::delete('/{id}', [ImagemController::class, 'destroy']);  
});


//Route:: catalogos
Route::group([ 
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'catalogo',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) { 
    Route::post('/', [CatalogoController::class, 'store']); 
    Route::patch('/', [CatalogoController::class, 'edit']); 
    Route::get('/random', [CatalogoController::class, 'random']); 
    Route::get('/{id}', [CatalogoController::class, 'find']); 
    Route::post('/filter', [CatalogoController::class, 'filter']); 
});


//Route:: categorias
Route::get('/categoria', [CategoriaTagController::class, 'list']); 
Route::post('/categoria', [CategoriaTagController::class, 'store']); 
Route::patch('/categoria', [CategoriaTagController::class, 'edit']); 
Route::get('/categoria/{id}', [CategoriaTagController::class, 'find']); 

 
//Route:: Account active and passwords
Route::post('/forgot', [SecurityController::class, 'forgot']); 
Route::post('/forgot/resend', [SecurityController::class, 'resend']); 
Route::put('/forgot/reset/password', [SecurityController::class, 'reset']);

//Route:: Auth
Route::group([ 
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});

//Route:: Users
Route::post('/user', [UserController::class, 'store']); 
 
//Route:: Users
Route::group([ 
    'middleware' => 'JWT:ROOT,ADMIN,USER',
    'prefix' => 'user',
    'roles' => ['ROOT', 'ADMIN', 'USER']

], function ($router) {

    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/filter/list/{search}', [UserController::class, 'search']);
    
    Route::put('/reset/password', [SecurityController::class, 'editPassword']);    
    Route::patch('/', [UserController::class, 'edit']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});


 
 

 


