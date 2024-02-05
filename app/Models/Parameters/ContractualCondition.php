<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ContractualCondition extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name'
    ];

    public function contractualCondition(){
        return $this->belongsTo('App\Models\Parameters\ContractualCondition');
    }

    protected $table = 'cfg_contractual_conditions';
}
