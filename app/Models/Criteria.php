<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['code', 'name', 'attribute', 'weight'];

    // Relasi: Satu kriteria punya banyak opsi sub-kriteria
    public function subCriterias()
    {
        return $this->hasMany(SubCriteria::class);
    }

    // Relasi: Satu kriteria punya banyak nilai evaluasi dari berbagai alternatif
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}