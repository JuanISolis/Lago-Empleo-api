<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\UsuarioController;

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\ExperienciaLaboralController;
use App\Http\Controllers\CapacidadController;
// use App\Http\Controllers\HabilidadController;
// use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\InformacioEmpresaController;
use App\Http\Controllers\LibreriaHabilidadController;
use App\Http\Controllers\LibreriaIdiomaController;
use App\Http\Controllers\OfertaLaboralController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\PostulanteController;

// endpoints de sesion
Route::prefix('sesion')->group(function () {

    // para iniciar sesio
    Route::post('/', [SesionController::class, 'iniciosesion']);

    // para resetear contraseña por una temporal
    Route::post('/resetpass', [SesionController::class, 'passolvidada']);    

});

// Crear usuario sin autenticación
Route::post('/user', [UserController::class, 'store']);


Route::get('/verofertaslaborales', [OfertaLaboralController::class, 'index']);
Route::get('/verempresas', [EmpresasController::class, 'index']);




// Route::apiResource('habilidad', HabilidadController::class);
// Route::apiResource('idioma', IdiomaController::class);
Route::apiResource('informacion_empresa', InformacioEmpresaController::class);
//Route::apiResource('libreria_habilidad', LibreriaHabilidadController::class);
//Route::apiResource('libreria_idioma', LibreriaIdiomaController::class);

// endpoints con acceso restringido por token
Route::middleware('auth:sanctum')->group(function () {
      
  Route::post('/actualizarperfil', [UsuarioController::class, 'actualizarPerfil']);

    // para cerrar sesion
    Route::post('/logout', [SesionController::class, 'logout']);

    // controla la tabla user, credenciales de sesion como correo, password o rol
    Route::apiResource('user', UserController::class)->except(['store']);
    Route::put('resetpassword', [UserController::class, 'actualizarPassword']);

    // informacion del usuario, datos basicos
    Route::get('/perfil', [UsuarioController::class, 'show']);
    Route::put('/actualizarperfil', [UsuarioController::class, 'actualizarperfil']);
    Route::apiResource('usuario', UsuarioController::class);

    Route::apiResource('actividad', ActividadController::class);

    Route::put('/actualizarempresa', [EmpresasController::class, 'actualizarempresa']);
    Route::get('/VermiEmpresa', [EmpresasController::class, 'mostrarEmpresa']);
    Route::apiResource('empresas', EmpresasController::class)->except(['index']);

    Route::get('/infopostulante',[PostulanteController::class,'infopostulante'] );

    Route::put('/actualizarpostulante', [PostulanteController::class, 'actualizarpostulante']);

    Route::apiResource('postulante', PostulanteController::class);

    Route::apiResource('estudio', EstudioController::class);

    Route::apiResource('experiencia_laboral', ExperienciaLaboralController::class);

    Route::apiResource('capacidad', CapacidadController::class);

    Route::apiResource('oferta_laboral', OfertaLaboralController::class)->except(['index']);

    Route::apiResource('postulacion', PostulacionController::class);
    
});