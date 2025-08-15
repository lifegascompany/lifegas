<?php

use App\Http\Controllers\PdfController;
use App\Livewire\CrearCitas;
use App\Livewire\Inicio;
use App\Livewire\ListaCitas;
use App\Livewire\ListaExpedientes;
use App\Livewire\ListaVehiculos;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('index');
});

Route::get('index', function () {
    return view('index');
});

/*Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');

RateLimiter::for('livewire', function (Request $request) {
    return Limit::perMinute(10)->by($request->ip()); // Máx 10 solicitudes por minuto por IP
});

Route::middleware('throttle:livewire')->group(function () {
    Route::post('/livewire/message/{component}', '\Livewire\Controllers\HttpConnectionHandler');
});*/

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {

    /*Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');*/

     Route::get('/inicio', Inicio::class)->name('inicio');

     // Citas
     Route::get('/lista-citas', ListaCitas::class)->name('ListaCitas');
     Route::get('/crear-cita', CrearCitas::class)->name('CrearCita');

    // Vehículos
    Route::get('/lista-vehiculos', ListaVehiculos::class)->name('ListaVehiculos'); 

    // Expedientes
    Route::get('/lista-expedientes', ListaExpedientes::class)->name('ListaExpedientes');

    // PDF Routes
    Route::get('/vehiculo/pdf/{id}', [PdfController::class, 'generaPdfCartaGarantia'])->name('vehiculo.pdf');
    Route::get('/manual/pdf/{id}', [PdfController::class, 'generaPdfManual'])->name('manual.pdf');


});
