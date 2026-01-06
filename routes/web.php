<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DssController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlternativeController; // <--- JANGAN LUPA IMPORT INI

// --- GROUP GUEST ---
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// --- GROUP AUTH ---
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Menu DSS (Evaluasi)
    Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluation.index');
    Route::post('/evaluation', [EvaluationController::class, 'update'])->name('evaluation.update');
    Route::get('/result', [DssController::class, 'index'])->name('dss.result');

    // --- TAMBAHKAN INI (CRUD ALTERNATIF) ---
    Route::post('/alternatives', [AlternativeController::class, 'store'])->name('alternatives.store');
    Route::delete('/alternatives/{id}', [AlternativeController::class, 'destroy'])->name('alternatives.destroy');
    
    // Redirect pengaman jika user akses /alternatives langsung di browser
    Route::get('/alternatives', function () {
        return redirect()->route('evaluation.index');
    });
});