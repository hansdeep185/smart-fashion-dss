<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    // Menampilkan Form Matriks
    public function index()
    {
        $alternatives = Alternative::with('evaluations')->get();
        $criterias = Criteria::with('subCriterias')->get(); // Load sub-kriteria untuk dropdown

        return view('evaluation.index', compact('alternatives', 'criterias'));
    }

    // Menyimpan/Update Nilai Matriks
    public function update(Request $request)
    {
        // Ambil data dari form
        $inputs = $request->input('values');

        // --- PERBAIKAN: Cek apakah ada data yang dikirim? ---
        if (is_null($inputs) || !is_array($inputs)) {
            return redirect()->back()->with('error', 'Tidak ada data penilaian yang disimpan. Pastikan Tabel Alternatif sudah ada datanya.');
        }
        // ----------------------------------------------------

        foreach ($inputs as $altId => $criteriaValues) {
            foreach ($criteriaValues as $critId => $subCriteriaValue) {
                Evaluation::updateOrCreate(
                    [
                        'alternative_id' => $altId,
                        'criteria_id' => $critId,
                    ],
                    [
                        'value' => $subCriteriaValue
                    ]
                );
            }
        }

        return redirect()->route('dss.result')->with('success', 'Penilaian berhasil disimpan!');
    }
}