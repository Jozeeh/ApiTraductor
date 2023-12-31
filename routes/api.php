<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FavoritosController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// -------------------------------------------
// -- RUTAS API INICIO DE SESION Y REGISTRO --
// -------------------------------------------
Route::post('/login', [AccountController::class, 'login']);
Route::post('/registro', [AccountController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (){
    // ------------------------------
    // -- OBTENER DATOS DE USUARIO --
    // ------------------------------
    Route::get('/getDatosUsuario/{id}', [AccountController::class, 'getDatosUsuario']);

    // -------------------------------------------------------
    // -- RUTAS ACTUALIZAR DATOS/CORREO/PASSWORD DE USUARIO --
    // -------------------------------------------------------
    Route::put('/updateDatosUsuario/{id}', [AccountController::class, 'updateDatosUsuario']);
    Route::put('/updateCorreoUsuario/{id}', [AccountController::class, 'updateCorreoUsuario']);

    // -------------------------------------------------------
    // -- RUTAS PARA ALMACENAR PALABRA FAVORITA EN LA BASE  --
    // -------------------------------------------------------
    Route::post('/registrarPalabra', [FavoritosController::class, 'store']);
    Route::get('/mostrarPalabra', [FavoritosController::class, 'mostrarPalabra']);
    Route::delete('/eliminarFavorito/{id}', [FavoritosController::class, 'eliminarFavorito']);
 });

 Route::put('/updatePasswordUsuario/{id}', [AccountController::class, 'updatePasswordUsuario']);