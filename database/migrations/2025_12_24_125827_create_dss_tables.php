<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kriteria
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // C1, C2, dst
            $table->string('name');
            $table->enum('attribute', ['benefit', 'cost']);
            $table->double('weight'); // Dalam persen (misal 25.0)
            $table->timestamps();
        });

        // 2. Tabel Sub Kriteria (Untuk opsi penilaian)
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->string('name'); // Contoh: "Sangat Trendy"
            $table->integer('value'); // Contoh: 5
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Alternatif (Produk Design)
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // A1, A2
            $table->string('name'); // Design A - A-Line Dress
            $table->timestamps();
        });

        // 4. Tabel Penilaian (Matrix Keputusan)
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->double('value'); // Nilai skor (1-5)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('alternatives');
        Schema::dropIfExists('sub_criterias');
        Schema::dropIfExists('criterias');
    }
};