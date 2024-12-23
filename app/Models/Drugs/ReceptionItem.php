<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ReceptionItem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_reception_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'substance_id',
        'nue',
        'sample_number',
        'document_weight',
        'gross_weight',
        'net_weight',
        'estimated_net_weight',
        'sample',
        'countersample_number',
        'countersample',
        'destruct',
        'countersample_destruction_id',
        'equivalent',
        'result_number',
        'result_date',
        'result_substance_id',
        'dispose_precursor',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'result_date'       => 'date',
        'dispose_precursor' => 'boolean',
    ];

    /**
     * Get the reception that owns the reception item.
     */
    public function reception(): BelongsTo
    {
        return $this->belongsTo(Reception::class);
    }

    /**
     * Get the substance that owns the reception item.
     */
    public function substance(): BelongsTo
    {
        return $this->belongsTo(Substance::class);
    }

    /**
     * Get the result substance that owns the reception item.
     */
    public function resultSubstance(): BelongsTo
    {
        return $this->belongsTo(Substance::class, 'result_substance_id');
    }

    /**
     * Get the protocols for the reception item.
     */
    public function protocols(): HasMany
    {
        return $this->hasMany(Protocol::class);
    }

    /**
     * Get the act precursor item for the reception item.
     */
    public function actPrecursorItem(): HasOne
    {
        return $this->hasOne(ActPrecursorItem::class);
    }

    public function countersampleDestruction(): BelongsTo
    {
        return $this->belongsTo(CountersampleDestruction::class);
    }

    /**
     * Get the letter form position.
     */
    public function getLetterFormPosition(int $position): string
    {
        $letras = [];

        // Genera las letras de la 'a' a la 'z'
        for ($i = ord('a'); $i <= ord('z'); $i++) {
            $letras[] = chr($i);
        }

        // Genera las letras de 'aa' a 'zz'
        for ($i = ord('a'); $i <= ord('z'); $i++) {
            for ($j = ord('a'); $j <= ord('z'); $j++) {
                $letras[] = chr($i).chr($j);
            }
        }

        return $letras[--$position];
    }

    /**
     * Get the letter attribute.
     */
    public function getLetterAttribute(): string
    {
        $position = $this->reception->items()->where('id', '<=', $this->id)->count();

        return $this->getLetterFormPosition($position);
    }
}
