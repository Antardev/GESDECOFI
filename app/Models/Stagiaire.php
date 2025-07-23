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

    public function controleur()
    {
        $controleur = Controleurs::where('country_contr', $this->country)->first();

        return $controleur;
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

    public function getSemester(): ?int
    {
        $currentDate = now(); // Date actuelle

        if ($currentDate->between($this->semester_0_begin, $this->semester_0_end)) {
            return 1;
        } elseif ($currentDate->between($this->semester_1_begin, $this->semester_1_end)) {
            return 2;
        } elseif ($currentDate->between($this->semester_2_begin, $this->semester_2_end)) {
            return 3;
        } elseif ($currentDate->between($this->semester_3_begin, $this->semester_3_end)) {
            return 4;
        } elseif ($currentDate->between($this->semester_4_begin, $this->semester_4_end)) {
            return 5;
        } elseif ($currentDate->between($this->semester_5_begin, $this->semester_5_end)) {
            return 6;
        }

        return null;
    }

    public function getYear(): ?int
    {
        $semester = $this->getSemester();

        if ($semester === null) {
            return null;
        }

        return intdiv($semester - 1, 2)+1;
    }

    public function getJTdone()
    {
        return $this->hasMany(JourneeTechnique::class);
    }

}
