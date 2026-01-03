<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubsidyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes d'authentification
Auth::routes();

// Routes pour les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Gestion des utilisateurs
    Route::resource('users', UserController::class)->except(['show']);

    // Gestion des devis
    Route::resource('quotes', QuoteController::class);
    Route::get('quotes/{id}/pdf', [QuoteController::class, 'generatePdf'])->name('quotes.pdf');

    // Gestion des projets
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Gestion des subventions
    Route::resource('subsidies', SubsidyController::class)->except(['show']);
});

// Routes publiques si nécessaire
Route::get('/public/quotes/{id}', [QuoteController::class, 'show'])->name('quotes.show')->middleware('auth');
