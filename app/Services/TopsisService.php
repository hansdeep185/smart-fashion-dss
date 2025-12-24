<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;

class TopsisService
{
    /**
     * Menjalankan seluruh proses perhitungan TOPSIS
     */
    public function calculate()
    {
        // 1. Ambil Data dari Database
        $alternatives = Alternative::all();
        $criterias = Criteria::all();
        $evaluations = Evaluation::all();

        // Mapping data penilaian agar mudah diakses: $scores[alt_id][crit_id] = nilai
        $scores = [];
        foreach ($evaluations as $eval) {
            $scores[$eval->alternative_id][$eval->criteria_id] = $eval->value;
        }

        // Cek jika data kosong untuk menghindari error
        if ($alternatives->isEmpty() || $criterias->isEmpty() || empty($scores)) {
            return null;
        }

        // --- LANGKAH 1: MATRIKS KEPUTUSAN (X) & PEMBAGI ---
        // Kita butuh pembagi (akar dari jumlah kuadrat) untuk setiap kriteria
        $divisors = [];
        foreach ($criterias as $criteria) {
            $sumSquared = 0;
            foreach ($alternatives as $alt) {
                $val = $scores[$alt->id][$criteria->id] ?? 0; // Default 0 jika belum dinilai
                $sumSquared += pow($val, 2);
            }
            $divisors[$criteria->id] = sqrt($sumSquared);
        }

        // --- LANGKAH 2: MATRIKS TERNORMALISASI (R) ---
        $normalizedMatrix = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $criteria) {
                $val = $scores[$alt->id][$criteria->id] ?? 0;
                $divisor = $divisors[$criteria->id];
                
                // Hindari pembagian dengan nol
                $normalizedMatrix[$alt->id][$criteria->id] = $divisor > 0 ? $val / $divisor : 0;
            }
        }

        // --- LANGKAH 3: MATRIKS TERNORMALISASI TERBOBOT (Y) ---
        $weightedMatrix = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $criteria) {
                // Bobot diambil langsung (misal 25, 30). 
                // Tidak perlu dibagi 100 karena nanti di hasil akhir rasionya tetap sama.
                $weightedMatrix[$alt->id][$criteria->id] = $normalizedMatrix[$alt->id][$criteria->id] * $criteria->weight;
            }
        }

        // --- LANGKAH 4: SOLUSI IDEAL POSITIF (A+) DAN NEGATIF (A-) ---
        $idealPositive = [];
        $idealNegative = [];

        foreach ($criterias as $criteria) {
            // Ambil satu kolom nilai untuk kriteria ini dari Weighted Matrix
            $columnValues = array_column(array_map(function($row) use ($criteria) {
                return $row[$criteria->id];
            }, $weightedMatrix), null);

            if ($criteria->attribute == 'benefit') {
                $idealPositive[$criteria->id] = max($columnValues); // Max itu Bagus
                $idealNegative[$criteria->id] = min($columnValues); // Min itu Jelek
            } else {
                // Cost (Meski C5 kamu benefit, kode ini jaga-jaga kalau ada kriteria cost lain)
                $idealPositive[$criteria->id] = min($columnValues); // Min itu Bagus (Murah)
                $idealNegative[$criteria->id] = max($columnValues); // Max itu Jelek (Mahal)
            }
        }

        // --- LANGKAH 5: JARAK SOLUSI (D+ & D-) ---
        $distancePositive = [];
        $distanceNegative = [];

        foreach ($alternatives as $alt) {
            $sumPos = 0;
            $sumNeg = 0;

            foreach ($criterias as $criteria) {
                $y = $weightedMatrix[$alt->id][$criteria->id];
                $aPos = $idealPositive[$criteria->id];
                $aNeg = $idealNegative[$criteria->id];

                $sumPos += pow($y - $aPos, 2);
                $sumNeg += pow($y - $aNeg, 2);
            }

            $distancePositive[$alt->id] = sqrt($sumPos);
            $distanceNegative[$alt->id] = sqrt($sumNeg);
        }

        // --- LANGKAH 6: NILAI PREFERENSI (V) ---
        $preferences = [];
        foreach ($alternatives as $alt) {
            $dPos = $distancePositive[$alt->id];
            $dNeg = $distanceNegative[$alt->id];
            
            // Rumus V = D- / (D- + D+)
            // Jika D- dan D+ keduanya 0 (kasus aneh), set 0
            if ($dNeg + $dPos == 0) {
                $v = 0;
            } else {
                $v = $dNeg / ($dNeg + $dPos);
            }

            $preferences[] = [
                'alternative_id' => $alt->id,
                'alternative_code' => $alt->code,
                'alternative_name' => $alt->name,
                'score' => $v
            ];
        }

        // --- LANGKAH 7: RANKING ---
        // Urutkan dari nilai V terbesar ke terkecil
        usort($preferences, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Tambahkan ranking number
        foreach ($preferences as $index => $item) {
            $preferences[$index]['rank'] = $index + 1;
        }

        // Return semua data agar bisa ditampilkan di View (Transparansi Perhitungan)
        return [
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'normalized_matrix' => $normalizedMatrix,
            'weighted_matrix' => $weightedMatrix,
            'ideal_positive' => $idealPositive,
            'ideal_negative' => $idealNegative,
            'distances' => [
                'positive' => $distancePositive,
                'negative' => $distanceNegative
            ],
            'ranks' => $preferences
        ];
    }
}