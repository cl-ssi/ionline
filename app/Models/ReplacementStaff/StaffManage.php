<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StaffManage extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'organizational_unit_id','replacement_staff_id'
    ];

    public function organizationalUnit() {
        return $this->belongsTo('App\Models\Rrhh\OrganizationalUnit');
    }

    public function replacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\ReplacementStaff');
    }

    public static function getStaffByOu(){
        return $staffManages = StaffManage::selectRaw('organizational_unit_id')
            ->groupBy('organizational_unit_id')
            ->get();
    }



    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_staff_manages';
}
