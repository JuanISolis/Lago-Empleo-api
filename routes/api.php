<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\UserController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\UsuarioController;



use App\Http\Controllers\ActividadController;
use App\Http\Controllers\EmpleadorController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\ExperienciaLaboralController;
use App\Http\Controllers\HabilidadController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\InformacioEmpresaController;
use App\Http\Controllers\LibreriaHabilidadController;
use App\Http\Controllers\LibreriaIdiomaController;
use App\Http\Controllers\OfertaLaboralController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\PostulanteController;


Route::apiResource('user', UserController::class);
Route::post('sesion/iniciarsesion', [SesionController::class, 'iniciosesion']);
Route::post('sesion/passolvido', [SesionController::class, 'passolvidada']);
Route::apiResource('usuario', UsuarioController::class);





Route::apiResource('actividad', ActividadController::class);
Route::apiResource('empleador', EmpleadorController::class);
Route::apiResource('estudio', EstudioController::class);
Route::apiResource('experiencia_laboral', ExperienciaLaboralController::class);
Route::apiResource('habilidad', HabilidadController::class);
Route::apiResource('idioma', IdiomaController::class);
Route::apiResource('informacion_empresa', InformacioEmpresaController::class);
Route::apiResource('libreria_habilidad', LibreriaHabilidadController::class);
Route::apiResource('libreria_idioma', LibreriaIdiomaController::class);
Route::apiResource('oferta_laboral', OfertaLaboralController::class);
Route::apiResource('postulacion', PostulacionController::class);
Route::apiResource('postulante', PostulanteController::class);