<?php

namespace App\Models\RequestForms;

use App\Models\Parameters\PurchaseType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Tender extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'purchase_type_id', 'tender_number', 'description', 'resol_administrative_bases', 'resol_adjudication',
        'resol_deserted', 'resol_contract', 'guarantee_ticket', 'has_taking_of_reason',
        'status', 'supplier_id'
    ];

    public function purchaseType()
    {
        return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function attachedFiles()
    {
        return $this->hasMany(AttachedFile::class);
    }

    public function purchases()
    {
        return $this->hasMany(ImmediatePurchase::class);
    }

    protected $table = 'arq_tenders';
}
