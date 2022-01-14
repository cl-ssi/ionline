<?php

namespace App\Models\RequestForms;

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
        'tender_type', 'description', 'resol_administrative_bases', 'resol_adjudication',
        'resol_deserted', 'resol_contract', 'guarantee_ticket', 'has_taking_of_reason',
        'status', 'type_of_purchase', 'supplier_id'
    ];

    protected $table = 'arq_tenders';
}
