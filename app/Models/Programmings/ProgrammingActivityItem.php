<?php

namespace App\Models\Programmings;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammingActivityItem extends Pivot
{
    use SoftDeletes;
    
    protected $table = 'pro_programming_activity_item';

    protected $fillable = [
        'programming_id', 'activity_item_id', 'requested_by', 'observation', 'deleted_at', 'id'
    ];

    public function programming() {
        return $this->belongsTo(Programming::class);
    }

    public function activityItem() {
        return $this->belongsTo(ActivityItem::class);
    }

    public function requestedBy() {
        return $this->belongsTo(User::class, 'requested_by')->select(array('id', 'dv', 'name', 'fathers_family', 'mothers_family'));
    }
}