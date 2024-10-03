<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityItem extends Model
{
    use SoftDeletes;
    protected $table = 'pro_activity_items';
    protected $fillable = [
        'id', 'int_code', 'vital_cycle', 'tracer', 'action_type', 'activity_name', 'def_target_population', 'verification_rem', 'professional', 'activity_id', 'cods', 'cols', 'activity_item_id'
    ];

    public function program(){
        return $this->belongsTo('App\Models\Programmings\ActivityProgram', 'activity_id');
    }

    public function activityItem(){
        return $this->belongsTo('App\Models\Programmings\ActivityItem', 'activity_item_id');
    }

    public function programItems(){
        return $this->hasMany('App\Models\Programmings\ProgrammingItem')->orderBy('activity_id', 'ASC');
    }

    public function programming(){
        return $this->belongsToMany(Programming::class, 'pro_programming_activity_item')->withPivot('id', 'requested_by', 'observation')->whereNull('pro_programming_activity_item.deleted_at')->withTimestamps()->using(ProgrammingActivityItem::class);
    }
}
