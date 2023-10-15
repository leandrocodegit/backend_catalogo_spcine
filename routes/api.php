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
use App\Http\Controllers\DescricaoController;
use App\Http\Controllers\PrecoController;
use App\Http\Controllers\PerfilController;

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
    Route::post('/filtro', [FiltroController::class, 'count']);
});

//Route:: Icons
Route::group([
    'prefix' => 'icon'
], function ($router) {
    Route::get('/{id}', [IconController::class, 'show'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/find/list', [IconController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [IconController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::post('/update', [IconController::class, 'update'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::post('/associar', [IconController::class, 'associar'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);
    Route::delete('/{id}', [IconController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: Agendas
Route::group([
    'prefix' => 'agenda'
], function ($router) {
    Route::get('/{id}', [AgendaController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/find/list', [AgendaController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [AgendaController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [AgendaController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: Tipo de regas
Route::group([
    'prefix' => 'tipo/regra'
], function ($router) {
    Route::get('/{id}', [TipoRegraController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/find/list', [TipoRegraController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [TipoRegraController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [TipoRegraController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: Regas
Route::group([
    'prefix' => 'regra'
], function ($router) {
    Route::get('/{id}', [RegraController::class, 'show'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/find/list', [RegraController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [RegraController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [RegraController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::post('/associar', [RegraController::class, 'associar'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);

});

//Route:: Caracteristicas
Route::group([
    'prefix' => 'caracteristica'
], function ($router) {
    Route::get('/{id}', [CaracteristicaController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/find/list', [CaracteristicaController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [CaracteristicaController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::post('/associar', [CaracteristicaController::class, 'associar'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);
     Route::delete('/{id}', [CaracteristicaController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: Exports arquivos de relatorio
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN,GUEST',
    'prefix' => 'data'
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
    Route::post('/import/imagem', [ExportImportController::class, 'importImagens']);
    Route::post('/import/descricao', [ExportImportController::class, 'importDescricoes']);
    Route::post('/import/precos', [ExportImportController::class, 'importPrecos']);
    Route::post('/import/caracteristicas', [ExportImportController::class, 'importCaracteristicas']);
    Route::post('/import/responsavel', [ExportImportController::class, 'importUsuarios']);

});

//Route:: Imagens upload
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER',
    'prefix' => 'imagem',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::post('/', [ImagemController::class, 'store']);
    Route::post('/capas', [ImagemController::class, 'atualizarCapas']);
    Route::patch('/', [ImagemController::class, 'edit']);
    Route::get('/{id}', [ImagemController::class, 'find']);
    Route::get('/catalogo/{id}', [ImagemController::class, 'findPorCatalogo']);
    Route::delete('/{id}', [ImagemController::class, 'destroy']);
});


//Route:: catalogos
Route::group([
    'prefix' => 'catalogo'

], function ($router) {

    Route::get('/random', [CatalogoController::class, 'random']);
    Route::get('/list', [CatalogoController::class, 'list']);
    Route::get('/list/user/{userId}', [CatalogoController::class, 'listPorUser'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);
    Route::post('/search/list', [CatalogoController::class, 'search'])->middleware(['middleware' => 'no_inject']);
    Route::post('/filter/list', [CatalogoController::class, 'filter'])->middleware(['middleware' => 'no_inject']);
    Route::patch('/cordenada', [CatalogoController::class, 'update'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);
    Route::patch('/regiao', [CatalogoController::class, 'alterarRegiao'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);
    Route::patch('/active/{id}', [CatalogoController::class, 'active'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::patch('/responsavel', [CatalogoController::class, 'alterarResponsavel'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [CatalogoController::class, 'destroy'])->middleware(['middleware' => 'no_inject']);
    Route::get('/{id}', [CatalogoController::class, 'find'])->middleware(['middleware' => 'no_inject']);
    Route::post('/', [CatalogoController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::patch('/', [CatalogoController::class, 'edit'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,MANAGER']);
});

//Route:: catalogos descrições
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER',
    'prefix' => 'catalogo/descricao',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [DescricaoController::class, 'findPorCatalogo']);
    Route::post('/', [DescricaoController::class, 'store']);
    Route::delete('/{id}', [DescricaoController::class, 'destroy']);
    Route::patch('/destaque/{id}', [DescricaoController::class, 'destaque']);
});

//Route:: catalogos preços
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN,MANAGER',
    'prefix' => 'catalogo/preco',
    'roles' => ['ROOT', 'ADMIN']

], function ($router) {
    Route::get('/{id}', [PrecoController::class, 'findPorCatalogo']);
    Route::post('/', [PrecoController::class, 'store']);
    Route::delete('/{id}', [PrecoController::class, 'destroy']);
});


//Route:: Regioes
Route::group([
    'prefix' => 'regiao'
], function ($router) {
    Route::get('/list', [RegiaoController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/{id}', [RegiaoController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [RegiaoController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [RegiaoController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: Perfils
Route::group([
    'middleware' => 'JWT:ROOT,ADMIN',
    'prefix' => 'perfil',

], function ($router) {
    Route::get('/', [PerfilController::class, 'list']);
    Route::post('/', [PerfilController::class, 'alter']);
});

//Route:: administradores
Route::group([
    'prefix' => 'administrador'
], function ($router) {
    Route::get('/list', [AdministradorController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/{id}', [AdministradorController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [AdministradorController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [AdministradorController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: categorias de caracteristicas
Route::group([
        'prefix' => 'caracteristica/categoria'

], function ($router) {
    Route::get('/list', [CategoriaCaracteristicaController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::get('/{id}', [CategoriaCaracteristicaController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [CategoriaCaracteristicaController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::patch('/', [CategoriaCaracteristicaController::class, 'edit'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [CategoriaCaracteristicaController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
});

//Route:: Categorias catalogo
Route::group([
    'prefix' => 'catalogo/categoria'
], function ($router) {
    Route::get('/list', [CategoriaCatalogoController::class, 'list']);
    Route::get('/{id}', [CategoriaCatalogoController::class, 'find'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,MANAGER']);
    Route::post('/', [CategoriaCatalogoController::class, 'store'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::patch('/', [CategoriaCatalogoController::class, 'edit'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::delete('/{id}', [CategoriaCatalogoController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
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
    Route::get('refresh', [AuthController::class, 'refresh'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,CLIENT,MANAGER']);
    Route::post('token', [SecurityController::class, 'gerarToken'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::get('token/{token}', [AuthController::class, 'loginToken']);
    Route::delete('token/{userId}', [SecurityController::class, 'deleteToken'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::get('token/find/{userId}', [SecurityController::class, 'findToken'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::post('token/send', [SecurityController::class, 'enviarToken'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);

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
    'prefix' => 'user'
], function ($router) {

    Route::post('/filter/list', [UserController::class, 'search'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST', 'no_inject']);
    Route::put('/reset/password', [SecurityController::class, 'editPassword'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::patch('/perfil/update', [UserController::class, 'update'])->middleware(['middleware' => 'JWT:ROOT']);
    Route::patch('/status/update/{id}', [UserController::class, 'active'])->middleware(['middleware' => 'JWT:ROOT,ADMIN']);
    Route::get('/list', [UserController::class, 'list'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,CLIENT,MANAGER']);
    Route::get('/{id}', [UserController::class, 'show'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,CLIENT,MANAGER']);
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware(['middleware' => 'JWT:ROOT']);
    Route::patch('/', [UserController::class, 'edit'])->middleware(['middleware' => 'JWT:ROOT,ADMIN,GUEST,CLIENT,MANAGER']);

});


Route::get('/svg-file/', function () {
    $svgContent = \Illuminate\Support\Facades\Storage::disk('public')->get('regras/NP1lY7FwRG78pHsGEtx5L6P5x6veOzzLSwcHNYgr.svg');
    return response($svgContent, 200)->header('Content-Type', 'text');
});







