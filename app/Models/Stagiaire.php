<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $dates = ['first_year_begin', 'first_year_end'];
    
    public function rapports()
    {
        return $this->hasMany(Rapport::class)->orderBy('rapport_name', 'asc');
    }
    
    public function rapport_by_semester($semester)
    {
        
    }

    public function journee_techniques()
    {
        return $this->hasMany(JourneeTechnique::class)->orderBy('rapport_name', 'asc');
    }

    public function jt_year_1()
    {
        return $this->hasMany(JourneeTechnique::class)->where('jt_year', 1);
    }

    public function jt_year_2()
    {
        return $this->hasMany(JourneeTechnique::class)->where('jt_year', 2);
    }

    public function jt_year_3()
    {
        return $this->hasMany(JourneeTechnique::class)->where('jt_year', 3);
    }

    public function jt_by_year()
    {
        $jts = [
            JourneeTechnique::where('year', 1),
            JourneeTechnique::where('year', 2),
            JourneeTechnique::where('year', 3),
        ];
        return $jts;
    }
}
