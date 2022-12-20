<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Value extends Model implements Auditable
{
    // use HasFactory;
    // use \OwenIt\Auditing\Auditable;
    //
    // public $table = 'sr_values';
    //
    // protected $fillable = [
    //     'contract_type','type','work_type','amount', 'validity_from', 'estate','establishment_id'
    // ];
    //
    //
    // public function establishment() {
    //     return $this->belongsTo('\App\Models\Establishment', 'establishment_id');
    // }
}
