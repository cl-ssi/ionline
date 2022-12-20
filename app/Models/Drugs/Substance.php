<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'rama',
        'unit',
        'laboratory',
        'isp',
        'presumed',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_substances';

    public function items()
    {
        return $this->hasMany(ReceptionItem::class);
    }

    /* TODO: asociar result_substance en ReceptionItem a otro item. */
}
