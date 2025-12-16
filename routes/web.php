<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\SiembraController;
use App\Http\Controllers\MonitoreoController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\TipoCultivoController;
use App\Http\Controllers\EstadoSiembraController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\TipoSueloController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TipoSiembraController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/features', function () {
    return view('features');
})->name('features');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('cultivos', CultivoController::class);
Route::resource('siembras', SiembraController::class); 
Route::get('/monitoreo', [MonitoreoController::class, 'index'])->name('monitoreo.index');
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/tipos-cultivo', [TipoCultivoController::class, 'store'])->name('tipos-cultivo.store');
    Route::delete('/tipos-cultivo/{tipoCultivo}', [TipoCultivoController::class, 'destroy'])->name('tipos-cultivo.destroy');
    Route::post('/tipos-cultivo', [TipoCultivoController::class, 'store'])->name('tipos-cultivo.store');
    Route::delete('/tipos-cultivo/{tipoCultivo}', [TipoCultivoController::class, 'destroy'])->name('tipos-cultivo.destroy');
    Route::post('/tipos-suelo', [TipoSueloController::class, 'store'])->name('tipos-suelo.store');
    Route::delete('/tipos-suelo/{tipoSuelo}', [TipoSueloController::class, 'destroy'])->name('tipos-suelo.destroy');
    Route::post('/periodos', [PeriodoController::class, 'store'])->name('periodos.store');
    Route::delete('/periodos/{id}', [PeriodoController::class, 'destroy'])->name('periodos.destroy');
    Route::post('/rangos', [RangoController::class, 'store'])->name('rangos.store');
    Route::delete('/rangos/{id}', [RangoController::class, 'destroy'])->name('rangos.destroy');
    Route::post('/dimensiones', [DimensionController::class, 'store'])->name('dimensiones.store');
    Route::delete('/dimensiones/{id}', [DimensionController::class, 'destroy'])->name('dimensiones.destroy');
    Route::post('/estados-siembra', [EstadoSiembraController::class, 'store'])->name('estados-siembra.store');
    Route::delete('/estados-siembra/{estadoSiembra}', [EstadoSiembraController::class, 'destroy'])->name('estados-siembra.destroy');
    Route::resource('tipos-siembra', TipoSiembraController::class)->only(['store', 'destroy']);
Route::middleware('auth')->group(function () {
    Route::resource('evaluaciones', EvaluacionController::class)->except(['create', 'edit', 'update']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/monitoreo/latest/{siembra}', [MonitoreoController::class, 'getLatestData'])->name('monitoreo.latest');
    Route::get('/monitoreo/historico/{siembra}', [MonitoreoController::class, 'getHistoricos'])->name('monitoreo.historico');
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    Route::post('/evaluaciones', [EvaluacionController::class, 'store'])->name('evaluaciones.store');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__.'/auth.php';
