<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\ListaInvitadoController;
use App\Http\Controllers\RegaloController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/contacto', function () {
    return view('contact.form-contact');
})->name('contacto');

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('eventos', EventoController::class);
    Route::patch('eventos/{evento}/cancel', [EventoController::class, 'cancel'])->name('eventos.cancel');

    Route::prefix('eventos/{evento}')->group(function () {
        Route::get('invitados', [InvitadoController::class, 'index'])->name('eventos.invitados.index');
        Route::get('invitados/crear', [InvitadoController::class, 'create'])->name('eventos.invitados.create');
        Route::post('invitados', [InvitadoController::class, 'store'])->name('eventos.invitados.store');
        Route::get('invitados/{invitado}', [InvitadoController::class, 'show'])->name('eventos.invitados.show');
        Route::get('invitados/{invitado}/editar', [InvitadoController::class, 'edit'])->name('eventos.invitados.edit');
        Route::put('invitados/{invitado}', [InvitadoController::class, 'update'])->name('eventos.invitados.update');
        Route::delete('invitados/{invitado}', [InvitadoController::class, 'destroy'])->name('eventos.invitados.destroy');

        Route::get('listas-invitados', [ListaInvitadoController::class, 'index'])->name('eventos.listas-invitados.index');
        Route::get('listas-invitados/crear', [ListaInvitadoController::class, 'create'])->name('eventos.listas-invitados.create');
        Route::post('listas-invitados', [ListaInvitadoController::class, 'store'])->name('eventos.listas-invitados.store');
    });

    Route::get('listas-invitados/{lista_invitado}', [ListaInvitadoController::class, 'show'])->name('listas-invitados.show');
    Route::get('listas-invitados/{lista_invitado}/editar', [ListaInvitadoController::class, 'edit'])->name('listas-invitados.edit');
    Route::put('listas-invitados/{lista_invitado}', [ListaInvitadoController::class, 'update'])->name('listas-invitados.update');
    Route::delete('listas-invitados/{lista_invitado}', [ListaInvitadoController::class, 'destroy'])->name('listas-invitados.destroy');
    Route::post('listas-invitados/{lista_invitado}/invitado', [ListaInvitadoController::class, 'addGuest'])->name('listas-invitados.addGuest');
    Route::delete('listas-invitados/{lista_invitado}/invitado/{invitado}', [ListaInvitadoController::class, 'removeGuest'])->name('listas-invitados.removeGuest');

    Route::get('/invitados/creacion', [InvitadoController::class, 'createFront'])->name('invitados.creacion');
    Route::post('/invitados/creacion', [InvitadoController::class, 'storeFront'])->name('invitados.creacion.store');

    Route::get('/configuracion', function() {
        return view('profile.configuration');
    })->name('configuracion');

    Route::get('/regalos', [RegaloController::class, 'index'])->name('regalos.index');
    
    // Rutas para gestión de regalos y listas
    Route::post('/regalos/store', [RegaloController::class, 'storeGift'])->name('regalos.store');
    Route::post('/listas-regalos/store', [RegaloController::class, 'storeLista'])->name('listas-regalos.store');
    Route::post('/listas-regalos/{listaRegalo}/add', [RegaloController::class, 'addToList'])->name('listas-regalos.addToList');
    Route::put('/listas-regalos/{listaRegalo}', [RegaloController::class, 'updateLista'])->name('listas-regalos.update');
    Route::delete('/listas-regalos/{listaRegalo}', [RegaloController::class, 'destroyLista'])->name('listas-regalos.destroy');
});



// Rutas Demo para el Dashboard de Invitado
Route::get('/invitado', function() {
    return view('invitacionDashboard.confirmacion');
})->name('invitado.confirmacion');

Route::get('/invitado/regalos', function() {
    return view('invitacionDashboard.mesa-regalos');
})->name('invitado.regalos');

require __DIR__.'/auth.php';
