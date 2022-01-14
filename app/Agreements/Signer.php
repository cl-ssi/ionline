<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signer extends Model
{
    use HasFactory;
    protected $table = 'agr_signers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','appellative', 'decree', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }
}
