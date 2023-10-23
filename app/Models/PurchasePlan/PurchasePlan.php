<?php

namespace App\Models\PurchasePlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Documents\Approval;


class PurchasePlan extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_creator_id', 
        'user_responsible_id',
        'position',
        'telephone',
        'email',
        'organizational_unit_id',
        'organizational_unit',
        'subdirectorate_id',
        'subdirectorate',
        'subject',
        'description',
        'purpose',
        'program_id',
        'program',
        'estimated_expense',
        'approved_estimated_expense',
        'status',
        'period'
    ];

    public function userResponsible() {
        return $this->belongsTo('App\User', 'user_responsible_id')->withTrashed();
    }

    public function userCreator() {
        return $this->belongsTo('App\User', 'user_creator_id')->withTrashed();
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

    public function unspscProduct() {
        return $this->belongsTo('App\Models\Unspsc\Product', 'unspsc_product_id');
    }

    /**
     * Get all of the ModificationRequest's approvations.
     */
    public function approvals(): MorphMany{
        return $this->morphMany(Approval::class, 'approvable');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'ppl_purchase_plans';
}
