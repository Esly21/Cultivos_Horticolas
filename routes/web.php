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

    Route::post('/estados-siembra', [EstadoSiembraController::class, 'store'])->name('estados-siembra.store');
    Route::delete('/estados-siembra/{estadoSiembra}', [EstadoSiembraController::class, 'destroy'])->name('estados-siembra.destroy');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/monitoreo/latest/{siembra}', [MonitoreoController::class, 'getLatestData'])->name('monitoreo.latest');
    Route::get('/monitoreo/historico/{siembra}', [MonitoreoController::class, 'getHistoricos'])->name('monitoreo.historico');
});

require __DIR__.'/auth.php';
