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

    /* TODO: Borrar columnas category y estamento, ya que ahora pertenecen a la relación estament()
     * cambiar donde se estén ocupando, por la relación, ej: 
     * $profession->category => $profession->estament->category
     * $profession->estamento => $profession->estament->name
     */
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
