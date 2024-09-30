<?php

use App\Http\Controllers\JogadoresController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UsersController::class)->group(function () {
    Route::post('/cadastro', 'store');
    Route::post('/login', 'login');
});

    Route::controller(JogadoresController::class)->group(function () {
        Route::get('/jogadores', 'index');
        Route::post('/criar-jogador', 'store');
        Route::put('/atualizar-jogador', 'update');
        Route::put('/save-status', 'saveStatus');
        Route::delete('/excluir-jogador', 'destroy');
    });


