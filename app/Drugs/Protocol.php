<?php

namespace App\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Protocol extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sample','result','user_id','reception_item_id'
    ];


    public function receptionItem() {
        return $this->belongsTo('App\Drugs\ReceptionItem');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }


    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'drg_protocols';
}
