<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'file', 'name'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_files';

    //relaciones
    public function dispatch()
    {
        return $this->belongsTo('App\Models\Pharmacies\Dispatch');
    }
}
