<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DevisController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SubventionController;
use App\Http\Controllers\Api\DevisResponseController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\TechnicianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // User routes (only for admin)
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}/approve', [UserController::class, 'approve']);
        Route::put('/users/{id}/suspend', [UserController::class, 'suspend']);
    });
    
    // Technician routes - only approved technicians can access these
    Route::middleware(['status'])->group(function () {
        Route::apiResource('technicians', TechnicianController::class);
        Route::get('/technician/profile', [TechnicianController::class, 'getMyProfile']);
        Route::put('/technician/profile', [TechnicianController::class, 'updateProfile']);
        Route::get('/technician/devis', [TechnicianController::class, 'getAssignedDevis']);
        Route::get('/technician/responses', [TechnicianController::class, 'getMyResponses']);
    });
    
    // Devis routes
    Route::middleware(['status'])->group(function () {
        Route::apiResource('devis', DevisController::class);
        Route::put('/devis/{id}/assign-technician', [DevisController::class, 'assignTechnician']);
        Route::post('/devis/{id}/submit-response', [DevisController::class, 'submitResponse']);
        Route::post('/devis/{id}/accept-response', [DevisController::class, 'acceptResponse']);
    });
    
    // Devis Response routes
    Route::middleware(['status'])->group(function () {
        Route::apiResource('devis-responses', DevisResponseController::class);
        Route::put('/devis-responses/{id}/accept', [DevisResponseController::class, 'accept']);
        Route::put('/devis-responses/{id}/reject', [DevisResponseController::class, 'reject']);
    });
    
    // Component routes - only approved technicians can manage components
    Route::middleware(['status'])->group(function () {
        Route::apiResource('components', ComponentController::class);
        Route::get('/technician/components', [ComponentController::class, 'getByTechnician']);
    });
    
    // Project routes
    Route::middleware(['status'])->group(function () {
        Route::apiResource('projects', ProjectController::class);
        Route::put('/projects/{id}/update-status', [ProjectController::class, 'updateStatus']);
    });
    
    // Subvention routes - can only be created for accepted projects
    Route::middleware(['status'])->group(function () {
        Route::apiResource('subventions', SubventionController::class);
    });
});
