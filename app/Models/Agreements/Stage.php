<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Agreements\Agreement;

class Stage extends Model
{
    use SoftDeletes;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'agr_stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'group',
        'date',
        'dateEnd',
        'date_addendum',
        'dateEnd_addendum',
        'observation',
        'agreement_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'dateEnd' => 'date',
        'date_addendum' => 'date',
        'dateEnd_addendum' => 'date'
    ];

    /**
     * Get the agreement that owns the stage.
     */
    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    /**
     * Get the formatted date end text attribute.
     */
    public function getDateEndTextAttribute(): string
    {
        return $this->dateEnd ? 'Aceptado el ' . $this->dateEnd->format('d-m-Y') : ($this->date ? 'Enviado el ' . $this->date->format('d-m-Y') : 'En espera');
    }
}