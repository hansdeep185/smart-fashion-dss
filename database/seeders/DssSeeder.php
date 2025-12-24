<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DssSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Kriteria
        // Note: C5 saya set 'benefit' agar sesuai dengan skala 5 (Sangat Terjangkau)
        $criterias = [
            ['code' => 'C1', 'name' => 'Trend Score', 'attribute' => 'benefit', 'weight' => 25],
            ['code' => 'C2', 'name' => 'Kecocokan Bentuk Tubuh', 'attribute' => 'benefit', 'weight' => 30],
            ['code' => 'C3', 'name' => 'Minat Pelanggan', 'attribute' => 'benefit', 'weight' => 20],
            ['code' => 'C4', 'name' => 'Kesesuaian Kain', 'attribute' => 'benefit', 'weight' => 10],
            ['code' => 'C5', 'name' => 'Keterjangkauan Harga', 'attribute' => 'benefit', 'weight' => 10], 
            ['code' => 'C6', 'name' => 'Kelayakan Produksi', 'attribute' => 'benefit', 'weight' => 5],
        ];

        foreach ($criterias as $c) {
            DB::table('criterias')->insert($c);
        }

        // 2. Insert Alternatif
        $alternatives = [
            ['code' => 'A1', 'name' => 'Design A – A-Line Dress'],
            ['code' => 'A2', 'name' => 'Design B – Wrap Dress'],
            ['code' => 'A3', 'name' => 'Design C – Bodycon Dress'],
            ['code' => 'A4', 'name' => 'Design D – Oversized Outfit'],
            ['code' => 'A5', 'name' => 'Design F – Maxi Dress'],
            ['code' => 'A6', 'name' => 'Design H – Crop Top & Skirt'],
            ['code' => 'A7', 'name' => 'Design J – Jumpsuit Casual'],
        ];

        foreach ($alternatives as $a) {
            DB::table('alternatives')->insert($a);
        }

        // 3. Insert Sub Kriteria (Sample untuk C1 & C5 sebagai contoh, nanti bisa dilengkapi)
        // Saya ambil ID kriteria berdasarkan code untuk keamanan
        $c1_id = DB::table('criterias')->where('code', 'C1')->value('id');
        $c2_id = DB::table('criterias')->where('code', 'C2')->value('id');
        $c3_id = DB::table('criterias')->where('code', 'C3')->value('id');
        $c4_id = DB::table('criterias')->where('code', 'C4')->value('id');
        $c5_id = DB::table('criterias')->where('code', 'C5')->value('id');
        $c6_id = DB::table('criterias')->where('code', 'C6')->value('id');

        $subs = [
            // C1 Trend
            ['criteria_id' => $c1_id, 'name' => 'Sangat Trendy', 'value' => 5],
            ['criteria_id' => $c1_id, 'name' => 'Trendy', 'value' => 4],
            ['criteria_id' => $c1_id, 'name' => 'Moderately Trendy', 'value' => 3],
            ['criteria_id' => $c1_id, 'name' => 'Kurang Trendy', 'value' => 2],
            ['criteria_id' => $c1_id, 'name' => 'Tidak Trendy', 'value' => 1],
        
            // C2 Kecocokan Bentuk Tubuh
            ['criteria_id' => $c2_id, 'name' => 'Cocok untuk semua bentuk tubuh', 'value' => 5],
            ['criteria_id' => $c2_id, 'name' => 'Cocok untuk sebagian besar', 'value' => 4],
            ['criteria_id' => $c2_id, 'name' => 'Cocok untuk bentuk tubuh tertentu', 'value' => 3],
            ['criteria_id' => $c2_id, 'name' => 'Cocok untuk sedikit bentuk tubuh', 'value' => 2],
            ['criteria_id' => $c2_id, 'name' => 'Tidak cocok', 'value' => 1],

            // C3 Minat Pelanggan
            ['criteria_id' => $c3_id, 'name' => 'Permintaan sangat tinggi', 'value' => 5],
            ['criteria_id' => $c3_id, 'name' => 'Permintaan tinggi', 'value' => 4],
            ['criteria_id' => $c3_id, 'name' => 'Permintaan sedang', 'value' => 3],
            ['criteria_id' => $c3_id, 'name' => 'Permintaan rendah', 'value' => 2],
            ['criteria_id' => $c3_id, 'name' => 'Tidak diminati', 'value' => 1],

            // C4 Kesesuaian Kain
            ['criteria_id' => $c4_id, 'name' => 'Sangat sesuai', 'value' => 5],
            ['criteria_id' => $c4_id, 'name' => 'Sesuai', 'value' => 4],
            ['criteria_id' => $c4_id, 'name' => 'Cukup sesuai', 'value' => 3],
            ['criteria_id' => $c4_id, 'name' => 'Kurang sesuai', 'value' => 2],
            ['criteria_id' => $c4_id, 'name' => 'Tidak sesuai', 'value' => 1],

            // C5 Harga (Keterjangkauan)
            ['criteria_id' => $c5_id, 'name' => 'Sangat terjangkau', 'value' => 5],
            ['criteria_id' => $c5_id, 'name' => 'Terjangkau', 'value' => 4],
            ['criteria_id' => $c5_id, 'name' => 'Cukup', 'value' => 3],
            ['criteria_id' => $c5_id, 'name' => 'Mahal', 'value' => 2],
            ['criteria_id' => $c5_id, 'name' => 'Sangat mahal', 'value' => 1],

            // C6 Harga (Kelayakan Produksi)
            ['criteria_id' => $c6_id, 'name' => 'Sangat mudah diproduksi', 'value' => 5],
            ['criteria_id' => $c6_id, 'name' => 'Mudah diproduksi', 'value' => 4],
            ['criteria_id' => $c6_id, 'name' => 'Cukup layak', 'value' => 3],
            ['criteria_id' => $c6_id, 'name' => 'Sulit diproduksi', 'value' => 2],
            ['criteria_id' => $c6_id, 'name' => 'Sangat sulit / tidak layak', 'value' => 1],
        ];

        DB::table('sub_criterias')->insert($subs);
    }
}