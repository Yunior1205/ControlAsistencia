<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EntradaSalidaController;
use App\Http\Controllers\LogEmpleadoController;

// Redirigir la página principal a /usuarios
Route::get('/', function () {
    return redirect('/usuarios');
});


Route::resource('/usuarios', UsuarioController::class);
Route::resource('/entradas_salidas', EntradaSalidaController::class);
Route::get('/usuario/consultar/{codigo_barras}', [UsuarioController::class, 'consultarPorCodigo']);
Route::get('/usuarios-puntuales', [UsuarioController::class, 'usuariosPuntuales'])->name('usuarios.puntuales');
Route::get('/usuarios-puntuales-departamento', [UsuarioController::class, 'puntualesPorDepartamento'])->name('usuarios.puntualesdepartamento');


// Ruta fallback para manejar rutas no encontradas
Route::fallback(function () {
    return redirect('/usuarios');
});