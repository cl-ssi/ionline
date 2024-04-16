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
        'period',
        'assign_user_id'
    ];

    public function userResponsible() {
        return $this->belongsTo('App\Models\User', 'user_responsible_id')->withTrashed();
    }

    public function userCreator() {
        return $this->belongsTo('App\Models\User', 'user_creator_id')->withTrashed();
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id')->withTrashed();
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

    public function hasApprovals(){
        return $this->approvals->count() > 0;
    }

    public function hasFirstApprovalSigned(){
        return $this->hasApprovals() && $this->approvals->first()->status == true;
    }

    public function canEdit(){
        return in_array($this->status, ['save', 'sent']); //|| !$this->hasFirstApprovalSigned();
    }

    public function canDelete(){
        return $this->status == 'save';
    }

    public function canAddPurchasePlanID(){
        return $this->status == 'approved';
    }

    public function hasDistributionCompleted(){
        foreach($this->purchasePlanItems as $item)
            if($item->quantity != $item->getScheduledQuantityAttribute())
                return false;
        return true;
    }

    public function getApprovalPending(){
        return $this->approvals->where('active', true)->whereNull('status')->first();
    }

    public function purchasePlanPublications(){
        return $this->hasMany('App\Models\PurchasePlan\PurchasePlanPublication', 'purchase_plan_id')->withTrashed();
    }

    public function assignPurchaser() {
        return $this->belongsTo('App\Models\User', 'assign_user_id')->withTrashed();
    }
    
    public function getStatus()
    {
        switch ($this->status) {
            case "save":
                return 'Guardado';
                break;
            case "sent":
                return 'Enviado';
                break;
            case "rejected":
                return 'Rechazado';
                break;
            case "approved":
                return 'Aprobado';
                break;
            case "published":
                return 'Publicado';
                break;
        }
    }

    public function getColorStatus()
    {
        switch ($this->status) {
            case "save":
                return 'primary';
                break;
            case "sent":
                return 'secondary';
                break;
            case "rejected":
                return 'danger';
                break;
            case "approved":
                return 'success';
                break;
            case "published":
                return 'info';
                break;
        }
    }

    public function scopeSearch(
        $query, $id_search, $status_search){
        if ($id_search OR $status_search){
            if ($id_search != '') {
                $query->where(function ($q) use ($id_search) {
                    $q->where('id', $id_search);
                });
            }
            if ($status_search != '') {
                $query->where(function ($q) use ($status_search) {
                    $q->where('status', $status_search);
                });
            }
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'ppl_purchase_plans';
}
