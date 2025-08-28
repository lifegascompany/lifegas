<?php

use App\Http\Controllers\PdfController;
use App\Livewire\AdminPermisos;
use App\Livewire\AdminRoles;
use App\Livewire\CrearCitas;
use App\Livewire\ExpedienteModal;
use App\Livewire\GestorRepuestos;
use App\Livewire\Inicio;
use App\Livewire\ListaCitas;
use App\Livewire\ListaClientes;
use App\Livewire\ListaConversiones;
use App\Livewire\ListaExpedientes;
use App\Livewire\ListaVehiculos;
use App\Livewire\SolicitudRepuestos;
use App\Livewire\Usuarios;
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

Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');

RateLimiter::for('livewire', function (Request $request) {
    return Limit::perMinute(10)->by($request->ip()); // Máx 10 solicitudes por minuto por IP
});

/*Route::middleware('throttle:livewire')->group(function () {
    Route::post('/livewire/message/{component}', '\Livewire\Controllers\HttpConnectionHandler');
});*/

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

     Route::get('/inicio', Inicio::class)->name('inicio');

     // Citas
     Route::get('/lista-citas', ListaCitas::class)->name('ListaCitas');
     Route::get('/crear-cita', CrearCitas::class)->name('CrearCita');

    // Expedientes
    Route::get('/lista-expedientes', ListaExpedientes::class)->name('ListaExpedientes');
    //Route::get('/evaluacion', ExpedienteModal::class)->name('evaluacion');

    // Conversiones
    Route::get('/lista-conversiones', ListaConversiones::class)->name('ListaConversiones');

    // Almacen
    Route::get('/gestor-repuestos', GestorRepuestos::class)->name('Repuestos');
    Route::get('/solicitud-repuestos/{conversionId}', SolicitudRepuestos::class)->name('SolicitudRepuestos');

    // Reportes

    // Vehículos
    Route::get('/lista-vehiculos', ListaVehiculos::class)->name('ListaVehiculos');

    // Clientes
    Route::get('/lista-clientes', ListaClientes::class)->name('ListaClientes'); 

    //Rutas modulo de Usuarios y Roles
    Route::get('/Usuarios', Usuarios::class)->name('usuarios');
    Route::get('/Roles', AdminRoles::class)->name('usuarios.roles');
    Route::get('/Permisos', AdminPermisos::class)->name('usuarios.permisos');

    

    // PDF Routes
    Route::get('/vehiculo/pdf/{id}', [PdfController::class, 'generaPdfCartaGarantia'])->name('vehiculo.pdf');
    Route::get('/manual/pdf/{id}', [PdfController::class, 'generaPdfManual'])->name('manual.pdf');
    Route::get('/ordenRepuestos/pdf/{id}', [PdfController::class, 'generaPdfOrdenRepuestos'])->name('ordenRepuestos.pdf');


});
