<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Presentation\Http\Actions\BuscarGifsAction;
use Presentation\Http\Actions\BuscarGifPorIdAction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/crearUsuario', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/buscarGifs', [BuscarGifsAction::class, 'execute']);
    Route::post('/buscarGifPorId', [BuscarGifPorIdAction::class, 'execute']);
});
