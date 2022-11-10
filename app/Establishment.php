<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Establishment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function commune()
    {
        return $this->belongsTo('\App\Models\Commune');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'deis', 'sirh_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'commune_id'
    ];
}
