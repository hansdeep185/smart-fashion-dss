<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $fillable = ['code', 'name'];

    // Relasi: Satu alternatif punya banyak nilai evaluasi
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}