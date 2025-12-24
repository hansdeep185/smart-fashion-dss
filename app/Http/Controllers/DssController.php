<?php

namespace App\Http\Controllers;

use App\Services\TopsisService;
use Illuminate\Http\Request;

class DssController extends Controller
{
    public function index(TopsisService $topsisService)
    {
        // Panggil fungsi calculate()
        $results = $topsisService->calculate();

        // Jika data kosong (belum ada inputan), kembalikan ke halaman INPUT (evaluation.index)
        if (!$results) {
            // PERBAIKAN: Ganti 'dashboard' menjadi 'evaluation.index'
            return redirect()->route('evaluation.index') 
                ->with('error', 'Data belum lengkap. Harap isi penilaian terlebih dahulu.');
        }

        // Kirim data ke view
        return view('dss.result', [
            'results' => $results
        ]);
    }
}