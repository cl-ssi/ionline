<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActPrecursorItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_act_precursor_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reception_item_id',
        'act_precursor_id',
    ];

    /**
     * // FIXME: El nombre de la relacion está mal
     * Get the reception item that owns the act precursor item.
     */
    public function reception_item(): BelongsTo
    {
        return $this->belongsTo(ReceptionItem::class);
    }

    /**
     * // FIXME: El nombre de la relacion está mal
     * Get the act precursor that owns the act precursor item.
     */
    public function act_precursor(): BelongsTo
    {
        return $this->belongsTo(ActPrecursor::class);
    }
}
