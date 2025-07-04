<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mission;

class MissionSubCategorie extends Model
{
    use HasFactory;

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
