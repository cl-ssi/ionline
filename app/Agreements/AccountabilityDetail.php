<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountabilityDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'egressNumber','egressDate','docNumber','docType','docProvider',
        'description','paymentType','amount'
    ];

    public function accountability() {
        return $this->belongsTo('App\Agreements\Accountability');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'egressDate'];

    protected $table = 'agr_accountability_details';
}
