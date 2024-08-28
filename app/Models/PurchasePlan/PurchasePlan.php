<?php

namespace App\Models\PurchasePlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Documents\Approval;
use App\Models\RequestForms\RequestForm;

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
        return $this->belongsTo('App\Models\Rrhh\OrganizationalUnit', 'organizational_unit_id')->withTrashed();
    }

    public function programName()
    {
        return $this->belongsTo('App\Models\Parameters\Program', 'program_id');
    }

    public function purchasePlanItems() {
        return $this->hasMany('App\Models\PurchasePlan\PurchasePlanItem', 'purchase_plan_id');
    }

    public function purchasePlanItemsWithTrashed() {
        return $this->hasMany('App\Models\PurchasePlan\PurchasePlanItem', 'purchase_plan_id')->withTrashed();
    }

    public function requestForms() {
        return $this->hasMany(RequestForm::class);
    }

    public function getTotalEstimatedExpense()
    {
        $total = 0;
        foreach ($this->requestForms as $requestForm) {
            if ($requestForm->status == 'approved')
                $total += $requestForm->estimated_expense;
        }
        return $total;
    }

    public function getTotalExpense()
    {
        $total = 0;
        foreach ($this->requestForms as $requestForm) {
            if ($requestForm->purchasingProcess)
                $total += $requestForm->purchasingProcess->getExpense();
        }
        return $total;
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
    public function trashedApprovals(): MorphMany{
        return $this->morphMany(Approval::class, 'approvable')->withTrashed();
    }

    public function hasApprovals(){
        return $this->approvals->count() > 0;
    }

    public function hasFirstApprovalSigned(){
        return $this->hasApprovals() && $this->approvals->first()->status == true;
    }

    public function canEdit(){
        return in_array($this->status, ['save', 'sent', 'rejected']); //|| !$this->hasFirstApprovalSigned();
    }

    public function canDelete(){
        return $this->status != 'published';
    }

    public function canAddPurchasePlanID(){
        return $this->status == 'approved';
    }

    public function canCreateRquestForm(){
        return $this->status == 'published';
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
        $query, $id_search, $status_search, $search_subject, $start_date_search, $end_date_search, $user_creator_search, $user_responsible_search,
            $responsible_ou_id, $program_search){
        if ($id_search OR $status_search OR $search_subject OR $start_date_search OR $end_date_search OR $user_creator_search OR 
            $user_responsible_search OR $responsible_ou_id OR $program_search){
            // dd($user_responsible_search);

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
            if ($search_subject != '') {
                $query->where(function ($q) use ($search_subject) {
                    $q->where('subject', 'LIKE', '%' . $search_subject . '%');
                });
            }
            if ($start_date_search != '' && $end_date_search != '') {
                $query->where(function ($q) use ($start_date_search, $end_date_search) {
                    $q->whereBetween('created_at', [$start_date_search, $end_date_search . " 23:59:59"])->get();
                });
            }
            $array_requester_search = explode(' ', $user_creator_search);
            foreach ($array_requester_search as $word) {
                $query->whereHas('userCreator', function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orwhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orwhere('mothers_family', 'LIKE', '%' . $word . '%');
                });
            }
            $array_responsible_search = explode(' ', $user_responsible_search);
            foreach ($array_responsible_search as $word) {
                $query->whereHas('userResponsible', function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orwhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orwhere('mothers_family', 'LIKE', '%' . $word . '%');
                });
            }
            if ($responsible_ou_id != '') {
                $query->where(function ($q) use ($responsible_ou_id) {
                    $q->where('organizational_unit_id', $responsible_ou_id);
                });
            }
            if ($program_search != '') {
                $query->where(function ($q) use ($program_search) {
                    $q->where('program', 'LIKE', '%' . $program_search . '%');
                });
            }
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'ppl_purchase_plans';
}
