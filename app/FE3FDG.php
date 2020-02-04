<?php

namespace App;

use \DateTime;
use Illuminate\Database\Eloquent\Model;

class FE3FDG extends Model
{
    protected $table = 'fe3fdg';
    protected $guarded = [];
    protected $dates = ['birthdate', 'tutor_birthdate_1', 'tutor_birthdate_2'];

    protected $relationships = ['Madre', 'Padre', 'Tutor'];
    protected $studyLevels = ['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'];
    protected $houseStatus = ['Otra', 'Propia', 'Propia, pero la está pagando', 'Rentada', 'Prestada', 'Intestada o en litigio'];
    protected $serviceTypes = ['Orientación/Consejo breve', 'Evaluación', 'Intervención'];
    protected $modalities = ['Individual/Grupal', 'Familiar/Pareja'];
    protected $times = ['Matutino', 'Vespertino', 'Indiferente'];
    
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name.' '.$this->mothers_name;
    }
    public function getIsUnderAgeAttribute()
    {
        return $this->birthdate->age < 18;
    }

    public function getMaritalAttribute() {
        $status = ['Soltera(o)', 'Casada(o)', 'Unión libre', 'Viuda(o)', 'Separada(o)', '?', '??'];
        return $status[$this->marital_status];
    }

    public function getRequesterAttribute() {
        $options = ['La persona', 'Padres o tutores', 'Otro familiar', 'Otro'];
        return $options[$this->person_requesting];
    }

    public function getRel1Attribute() { return @$this->relationships[$this->relationship_1]; }

    public function getTStudies1Attribute() { return @$this->studyLevels[$this->studies_level_1]; }

    public function getRel2Attribute() { return @$this->relationships[$this->relationship_2]; }

    public function getTStudies2Attribute() { return @$this->studyLevels[$this->studies_level_2]; }

    public function getStudyLevelAttribute() { return @$this->studyLevels[$this->scholarship]; }
    
    public function getHousingAttribute() { return @$this->houseStatus[$this->house_is]; }

    public function getSerTypeAttribute() { return @$this->serviceTypes[$this->service_type]; }

    public function getSerModAttribute() { return @$this->modalities[$this->service_modality]; }

    public function getPhonesAttribute()
    {
        $phones = "Ninguno";
        if ($this->house_phone) {
            $phones = $this->house_phone;
        }
        if ($this->cell_phone) {
            if ($phones != "Ninguno") {
                $phones = $phones." / ".$this->cell_phone;
            } else {
                $phones = $this->cell_phone;
            }
        }
        if ($this->work_phone) {
            if ($phones != "Ninguno") {
                $phones = $phones." / ".$this->work_phone;
            } else {
                $phones = $this->work_phone;
            }
        }
        return $phones;
    }

    public function getTimesAttribute() { return @$this->times[$this->prefer_time]; }

    public function prev_program()
    {
        return $this->belongsTo(Building::class, 'unam_previous_treatment_program', 'id_centro');
    }

    public function assigned_program()
    {
        return $this->belongsTo(Building::class, 'program', 'id_centro');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function center()
    {
        return $this->belongsTo('App\Building', 'center_id', 'id_centro');
    }

    public function super_user()
    {
        return $this->belongsTo(User::class, 'supervisor');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'id', 'fdg_id');
    }

}
