<?php

namespace App\Models\Allowances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Destination extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'commune_id', 'locality_id', 'description', 'allowance_id'
    ];

    public function allowance() {
        return $this->belongsTo('App\Models\Allowances\Allowance', 'allowance_id');
    }

    public function commune() {
        return $this->belongsTo('\App\Models\ClCommune', 'commune_id');
    }

    public function locality() {
        return $this->belongsTo('\App\Models\ClLocality', 'locality_id');
    }

    protected $table = 'alw_destinations';
}
