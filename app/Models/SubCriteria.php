<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    protected $fillable = ['criteria_id', 'name', 'value', 'description'];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}