<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Profile extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'profile_manage_id','profession_manage_id', 'experience', 'file', 'degree_date','replacement_staff_id'
    ];

    public function replacement_staff() {
        return $this->belongsTo('App\Models\ReplacementStaff\ReplacementStaff');
    }

    public function profile_manage() {
        return $this->belongsTo('App\Models\ReplacementStaff\ProfileManage');
    }

    public function profession_manage() {
        return $this->belongsTo('App\Models\ReplacementStaff\ProfessionManage');
    }

    public function getYearsOfDegreeAttribute()
    {
        $degreeDate = Carbon::parse($this->degree_date);
        $diff = $degreeDate->diffInYears(Carbon::now()->toDateString());

        return $diff;
    }

    public function getExperienceValueAttribute(){
        switch ($this->experience) {
            case 'managerial':
              return 'Directivo';
              break;
            case 'administrative management':
              return 'Gestión Administrativa';
              break;
            case 'healthcare':
              return 'Asistencial (clínica u hospitalaria)';
              break;
            case 'operations':
              return 'Operaciones';
              break;
            default:
              return '';
              break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
      'degree_date'
    ];

    protected $table = 'rst_profiles';
}
