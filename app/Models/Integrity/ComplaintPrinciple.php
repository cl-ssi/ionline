<?php

namespace App\Models\Integrity;

use Illuminate\Database\Eloquent\Model;

class ComplaintPrinciple extends Model
{
    public function complaint() {
        return $this->hasMany('App\Models\Integrity\Complaint');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
