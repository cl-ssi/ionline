<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Profession extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    public $table = 'cfg_professions';

    protected $fillable = [
        'name',
        'estament_id',
        'category',
        'estamento',
        'sirh_plant',
        'sirh_profession',
    ];

    public function estament()
    {
        return $this->belongsTo(Estament::class);
    }
    
}
