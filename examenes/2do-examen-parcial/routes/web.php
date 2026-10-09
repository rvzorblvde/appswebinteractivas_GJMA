<?php

use App\Http\Controllers\Admin\InscripcionController as AdminInscripcionController;
use App\Http\Controllers\Admin\TorneoController as AdminTorneoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\TorneoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('torneos.index'));

// Invitados
Route::get('/torneos', [TorneoController::class, 'index'])->name('torneos.index');
Route::get('/torneos/{torneo}', [TorneoController::class, 'show'])->name('torneos.show');

// Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Solo jugadores
Route::middleware('auth', 'rol:jugador')->group(function () {
    Route::get('/mis-torneos', [InscripcionController::class, 'index'])->name('mis-torneos');
    Route::post('/torneos/{torneo}/inscribirse', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::delete('/torneos/{torneo}/inscripcion', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');
});

// Solo admin
Route::middleware('auth', 'rol:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('torneos', AdminTorneoController::class);
    Route::delete('torneos/{torneo}/inscripciones/{inscripcion}', [AdminInscripcionController::class, 'destroy'])
        ->name('inscripciones.destroy');
});
