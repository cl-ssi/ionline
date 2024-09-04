<?php

namespace App\Models\Parameters;

use App\Models\ProfAgenda\ProfessionMessage;
use App\Models\ProfAgenda\Proposal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Profession extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
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

    public function estament(): BelongsTo
    {
        return $this->belongsTo(Estament::class);
    }

    public function agendaProposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function professionMessages(): HasMany
    {
        return $this->hasMany(ProfessionMessage::class);
    }
}
