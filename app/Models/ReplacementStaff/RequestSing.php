<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestSing extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'leadership_request_status', 'leadership_observation', 'leadership_date_sing',
        'sub_request_status', 'sub_observation', 'sub_date_sing',
        'sub_rrhh_request_status', 'sub_rrhh_observation', 'sub_rrhh_date_sing',
        'request_replacement_staff_id'
    ];

    public function requestReplacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    public function organizationalUnitSub() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'sub_organizational_unit_id');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_request_sings';
}
