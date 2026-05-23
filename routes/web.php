<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\ListaInvitadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/contacto', function () {
    return view('contact.form-contact');
})->name('contacto');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('eventos', EventoController::class);

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

    Route::get('/invitados/creacion', [InvitadoController::class, 'createFront'])->name('invitados.creacion');
    Route::post('/invitados/creacion', [InvitadoController::class, 'storeFront'])->name('invitados.creacion.store');

    Route::get('/configuracion', function() {
        return view('profile.configuration');
    })->name('configuracion');

    Route::get('/regalos', function() {
        return view('regalos.creacion-lista-regalos');
    })->name('regalos.index');
});



require __DIR__.'/auth.php';
