<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ImagemController;
use App\Http\Controllers\CategoriaCaracteristicaController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\CaracteristicaController;
use App\Http\Controllers\RegraController;
use App\Http\Controllers\TipoRegraController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\CategoriaCatalogoController;
use App\Http\Controllers\RegiaoController;
use \App\Http\Controllers\AdministradorController;
use \App\Http\Controllers\PainelController;

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


//Route:: Icons
Route::group([
    'prefix' => 'util'

], function ($router) {
    Route::get('/filtro', [FiltroController::class, 'filtro']);
});

//Route:: Icons
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'icon',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [IconController::class, 'show']);
    Route::get('/find/list', [IconController::class, 'list']);
    Route::post('/', [IconController::class, 'store']);
    Route::post('/update', [IconController::class, 'update']);
    Route::post('/associar', [IconController::class, 'associar']);
    Route::delete('/{id}', [IconController::class, 'destroy']);
});

//Route:: Agendas
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'agenda',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [AgendaController::class, 'find']);
    Route::get('/find/list', [AgendaController::class, 'list']);
    Route::post('/', [AgendaController::class, 'store']);
    Route::delete('/{id}', [AgendaController::class, 'destroy']);
});

//Route:: Tipo de regas
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'tipo/regra',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [TipoRegraController::class, 'find']);
    Route::get('/find/list', [TipoRegraController::class, 'list']);
    Route::post('/', [TipoRegraController::class, 'store']);
    Route::delete('/{id}', [TipoRegraController::class, 'destroy']);
});

//Route:: Regas
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'regra',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [RegraController::class, 'show']);
    Route::get('/find/list', [RegraController::class, 'list']);
    Route::post('/', [RegraController::class, 'store']);
    Route::delete('/{id}', [RegraController::class, 'destroy']);
});

//Route:: Tags
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'caracteristica',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [CaracteristicaController::class, 'find']);
    Route::get('/find/list', [CaracteristicaController::class, 'list']);
    Route::post('/', [CaracteristicaController::class, 'store']);
    Route::delete('/{id}', [CaracteristicaController::class, 'destroy']);
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
    Route::post('/search/list', [CatalogoController::class, 'search']);
    Route::post('/filter/list', [CatalogoController::class, 'filter']);
    Route::patch('/cordenada', [CatalogoController::class, 'update']);
    Route::patch('/active/{id}', [CatalogoController::class, 'active']);
});

//Route:: Regioes
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'regiao',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/list', [RegiaoController::class, 'list']);
    Route::post('/', [RegiaoController::class, 'store']);
    Route::get('/{id}', [RegiaoController::class, 'find']);
    Route::delete('/{id}', [RegiaoController::class, 'destroy']);
});

//Route:: administradores
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'administrador',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/list', [AdministradorController::class, 'list']);
    Route::post('/', [AdministradorController::class, 'store']);
    Route::get('/{id}', [AdministradorController::class, 'find']);
    Route::delete('/{id}', [AdministradorController::class, 'destroy']);
});

//Route:: categorias de caracteristicas
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
        'prefix' => 'caracteristica/categoria',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/list', [CategoriaCaracteristicaController::class, 'list']);
    Route::post('/', [CategoriaCaracteristicaController::class, 'store']);
    Route::patch('/', [CategoriaCaracteristicaController::class, 'edit']);
    Route::get('/{id}', [CategoriaCaracteristicaController::class, 'find']);
    Route::delete('/{id}', [CategoriaCaracteristicaController::class, 'destroy']);
});

//Route:: Categorias catalogo
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'catalogo/categoria',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/list', [CategoriaCatalogoController::class, 'list']);
    Route::post('/', [CategoriaCatalogoController::class, 'store']);
    Route::patch('/', [CategoriaCatalogoController::class, 'edit']);
    Route::get('/{id}', [CategoriaCatalogoController::class, 'find']);
    Route::delete('/{id}', [CategoriaCatalogoController::class, 'destroy']);
});


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
    Route::get('refresh', [AuthController::class, 'refresh']);

});

//Route:: Dashboard
Route::group([
    'prefix' => 'painel'

], function ($router) {

    Route::get('count', [PainelController::class, 'dash']);

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
    Route::post('/filter/list', [UserController::class, 'search']);

    Route::put('/reset/password', [SecurityController::class, 'editPassword']);
    Route::patch('/', [UserController::class, 'edit']);
    Route::patch('/perfil/update', [UserController::class, 'update']);
    Route::patch('/status/update/{id}', [UserController::class, 'active']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});








