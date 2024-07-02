<?php

namespace App\Models\ProfAgenda;

use App\Models\ProfAgenda\OpenHour;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalUser extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id','dv','name','fathers_family','mothers_family','gender','email','address','phone_number', 'birthday','active'
    ];

    protected $table = 'prof_agenda_external_users';

    protected $dates = ['birthday'];

    public function getShortNameAttribute()
    {
        return implode(' ', array(
            $this->name,
            mb_convert_case($this->fathers_family,MB_CASE_TITLE, 'UTF-8'),
            mb_convert_case($this->mothers_family,MB_CASE_TITLE, 'UTF-8')
        ));
    }

    public function getGender()
    {
        if(is_null($this->gender)) {
            return "";
        } else {
            if($this->gender == "male"){ return "Masculino"; }
            elseif($this->gender == "female"){ return "Femenino"; }
            else{ return "Otro"; }
        }
    }

    public function openHours(): HasMany
    {
        return $this->hasMany(OpenHour::class);
    }
}
