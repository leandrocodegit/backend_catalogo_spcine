<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('angular');
});
 

// Para ativar conta de usuário
Route::get('/account/active/{id}/{token}', [AuthController::class, 'active']);

// Redireciona para formulário de senha
Route::get('/account/reset/{id}/{token}', [UserController::class, 'valid']);

// Post formulário para redefinir senha;
Route::Post('/account/reset/password',  [UserController::class, 'reset']); 

 
 