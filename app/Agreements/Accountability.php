<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accountability extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month', 'document', 'date'
    ];

    public function agreement() {
        return $this->belongsTo('App\Agreements\Agreement');
    }

    public function details() {
        return $this->hasMany('App\Agreements\AccountabilityDetail');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date'];

    protected $table = 'agr_accountabilities';
}
