<?php

namespace App\Models\Integrity;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function value() {
        return $this->belongsTo('App\Models\Integrity\ComplaintValue', 'complaint_values_id');
    }

    public function principle() {
        return $this->belongsTo('App\Models\Integrity\ComplaintPrinciple', 'complaint_principles_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'content', 'email', 'know_code', 'identify','complaint_principles_id', 'complaint_values_id', 'other_value', 'user_id'
    ];
}
