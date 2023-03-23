<?php

namespace App\Models\Drugs;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActPrecursor extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_act_precursors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'full_name_receiving',
        'run_receiving',
        'note',
        'delivery_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date'
    ];

    public function delivery()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function precursors()
    {
        return $this->hasMany(ActPrecursorItem::class);
    }

    public function getFormatDateAttribute()
    {
        return $this->date->day . ' de ' . $this->date->monthName . ' del ' . $this->date->year;
    }
}