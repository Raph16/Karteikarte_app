<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\PaquetController;
use App\Http\Controllers\QuizzController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('paquages', 'pages/Paquages')
    ->middleware(['auth', 'verified'])
    ->name('paquages');

Route::get('revision/{slug}', [PaquetController::class,'show'])
    ->middleware(['auth', 'verified'])
    ->name('revision');

// Route::get('paquages/{sl', [PaquetController::class,'show'])
//     ->middleware(['auth', 'verified'])
//     ->name('revision');

Route::get('cartes', [CardController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('cartes');

Route::get('cartes/{id}', [CardController::class,'edit'])
    ->middleware(['auth', 'verified'])
    ->name('edit-card');

Route::get('quizz', [QuizzController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('quizz');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
