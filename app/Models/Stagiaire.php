<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $dates = ['first_year_begin', 'first_year_end'];

    protected $fillable = [
        'stage_begin',
        'semesester_0_begin',
        'semesester_0_end',
        'semesester_1_begin',
        'semesester_1_end',
        'semesester_2_begin',
        'semesester_2_end',
        'semesester_3_begin',
        'semesester_3_end',
        'semesester_4_begin',
        'semesester_4_end',
        'semesester_5_begin',
        'semesester_5_end',
    ];
    
    public function is_validated()
    {
        return $this->validated;
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class)->orderBy('rapport_name', 'asc');
    }

    public function rapports_year1()
    {
        return $this->hasMany(Rapport::class)->where('year', 1)->orderBy('rapport_name', 'asc');
    }

    public function rapports_year2()
    {
        return $this->hasMany(Rapport::class)->where('year', 2)->orderBy('rapport_name', 'asc');
    }

    public function rapports_year3()
    {
        return $this->hasMany(Rapport::class)->where('year', 3)->orderBy('rapport_name', 'asc');
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

    // public function mode_jt(){
    //     return $this->hasMany(JourneeTechnique::class)->select('mode')->distinct();
    // }

    public function getDisplayModeAttribute()
{
    $modeData = $this->journeeTechniques()->first()->mode ?? '';
    
    if (empty($modeData)) {
        return '-';
    }
    
    $decoded = json_decode($modeData, true);
    
    if (is_array($decoded) && isset($decoded['mode'])) {
        return match($decoded['mode']) {
            'Presentiel_horsPays' => 'Présentiel hors pays',
            'Presentiel_local' => 'Présentiel local',
            'En_ligne' => 'En ligne',
            default => $decoded['mode']
        };
    }
    
    return $modeData;
}
public function journeeTechniques()
    {
        return $this->hasMany(JourneeTechnique::class);
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

    public function isYearValidate($year)
    {
        if($this->hasOne(YearValidation::class)->where('year', $year)->exists())
        {
            return true;
        }
        return false;
    }

    public function allYearValidate()
    {
        if($this->hasOne(YearValidation::class)->where('year', 1)->exists() && $this->hasOne(YearValidation::class)->where('year', 2)->exists() && $this->hasOne(YearValidation::class)->where('year', 3)->exists())
        {
            return true;
        }
        return false;
    }

    public function hasEndStage()
    {

        if($this->hasOne(EndStage::class)->exists())
        {
            return true;
        }

        return false;

    }

    public function getSemester(): ?int
    {
        $currentDate = now(); // Date actuelle

        if ($currentDate->between($this->semester_0_begin, $this->semester_0_end)) {
            return 1;
        } elseif ($currentDate->between($this->semester_1_begin, $this->semester_1_end)) {
            return 2;
        } elseif ($currentDate->between($this->semester_2_begin, $this->semester_2_end)) {
            return 1;
        } elseif ($currentDate->between($this->semester_3_begin, $this->semester_3_end)) {
            return 2;
        } elseif ($currentDate->between($this->semester_4_begin, $this->semester_4_end)) {
            return 1;
        } elseif ($currentDate->between($this->semester_5_begin, $this->semester_5_end)) {
            return 2;
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
