<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroLoginController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// -------------------------------------------
// -- RUTAS API INICIO DE SESION Y REGISTRO --
// -------------------------------------------
Route::post('/login', [RegistroLoginController::class, 'login']);
Route::post('/registro', [RegistroLoginController::class, 'store']);
