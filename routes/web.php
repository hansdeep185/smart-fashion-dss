<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\DssController;
use App\Http\Controllers\AlternativeController;
use Illuminate\Support\Facades\Route;

// --- Route Halaman Utama (Input Penilaian) ---
Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluation.index');
Route::post('/evaluation', [EvaluationController::class, 'update'])->name('evaluation.update');

// --- Route Alternatif (CRUD) ---
Route::post('/alternatives', [AlternativeController::class, 'store'])->name('alternatives.store');
Route::delete('/alternatives/{id}', [AlternativeController::class, 'destroy'])->name('alternatives.destroy');

// --- TAMBAHAN PENTING (FIX ERROR) ---
// Jika user tidak sengaja akses /alternatives via browser, lempar balik ke halaman evaluation
Route::get('/alternatives', function () {
    return redirect()->route('evaluation.index');
});

// --- Route Hasil TOPSIS ---
Route::get('/dss/result', [DssController::class, 'index'])->name('dss.result');