<?php

namespace App\Models\PurchasePlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PurchasePlanPublication extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'mercado_publico_id',
        'date',
        'file',
        'purchase_plan_id',
        'user_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'ppl_purchase_plan_publications';
}
