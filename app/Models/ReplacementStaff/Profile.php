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
        'profile_manage_id','profession_manage_id', 'file', 'degree_date','replacement_staff_id'
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
        return Carbon::createFromDate($this->degree_date)->age;
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_profiles';
}
