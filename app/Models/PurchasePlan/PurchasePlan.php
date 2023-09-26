<?php

namespace App\Models\PurchasePlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PurchasePlan extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_creator_id', 'user_responsible_id', 'position', 'telephone', 'email', 'organizational_unit_id',
        'organizational_unit', 'subdirectorate_id', 'subdirectorate', 'subject', 'program_id', 'program', 'estimated_expense',
        'approved_estimated_expense', 'status', 'period'
    ];

    public function userResponsible() {
        return $this->belongsTo('App\User', 'user_responsible_id')->withTrashed();
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id');
    }

    public function programName()
    {
        return $this->belongsTo('App\Models\Parameters\Program', 'program_id');
    }

    public function purchasePlanItems() {
        return $this->hasMany('App\Models\PurchasePlan\PurchasePlanItem', 'purchase_plan_id');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'ppl_purchase_plans';
}
