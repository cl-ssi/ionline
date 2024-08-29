<?php

namespace App\Models\RequestForms;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RequestForms\PurchasingProcessDetail;
use App\Models\Parameters\Supplier;
use App\Models\Parameters\PurchaseType;

class Tender extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'purchase_type_id', 'tender_number', 'description', 'resol_administrative_bases', 'resol_adjudication',
        'resol_deserted', 'resol_contract', 'guarantee_ticket', 'has_taking_of_reason', 'taking_of_reason_date',
        'status', 'supplier_id', 'start_date', 'duration', 'justification', 'guarantee_ticket_exp_date', 'memo_number',
        'full_description', 'currency', 'creation_date', 'closing_date', 'initial_date', 'final_date', 'pub_answers_date', 
        'opening_act_date', 'pub_date', 'grant_date', 'estimated_grant_date', 'field_visit_date', 'n_suppliers'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'                => 'date',
        'guarantee_ticket_exp_date' => 'date',
        'creation_date'             => 'datetime',
        'closing_date'              => 'datetime',
        'initial_date'              => 'datetime', 
        'final_date'                => 'datetime', 
        'pub_answers_date'          => 'datetime',
        'opening_act_date'          => 'datetime', 
        'pub_date'                  => 'datetime', 
        'estimated_grant_date'      => 'datetime', 
        'grant_date'                => 'datetime', 
        'field_visit_date'          => 'datetime'
    ];

    public function purchaseType()
    {
        return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function purchasingProcessDetail()
    {
        return $this->hasOne(PurchasingProcessDetail::class);
    }

    public function attachedFiles()
    {
        return $this->hasMany(AttachedFile::class);
    }

    public function oc()
    {
        return $this->hasOne(ImmediatePurchase::class, 'tender_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    protected $table = 'arq_tenders';
}
