<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
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

    public function reception_item()
    {
        return $this->belongsTo(ReceptionItem::class);
    }

    public function act_precursor()
    {
        return $this->belongsTo(ActPrecursor::class);
    }
}