<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Programming extends Model
{
    protected $table = 'pro_programmings';
    protected $fillable = [
        'id','year', 'description'
    ];

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function items(){
        return $this->hasMany('App\Programmings\ProgrammingItem')->orderBy('activity_id', 'ASC');
    }

    public function days(){
        return $this->hasMany('App\Programmings\ProgrammingDay');
    }

    public function professionalHours(){
        return $this->hasMany('App\Programmings\ProfessionalHour');
    }

    public function establishment() {
        return $this->belongsTo('App\Establishment');
    }

    public function pendingItems(){
        return $this->belongsToMany(ActivityItem::class, 'pro_programming_activity_item')->withPivot('id', 'requested_by', 'observation')->whereNull('pro_programming_activity_item.deleted_at')->withTimestamps()->using(ProgrammingActivityItem::class);
    }

    public function countTotalReviewsBy($status) {
        $total=0;
        foreach($this->items as $item){
            $total += $item->getCountReviewsBy($status);
        }
        return $total;
    }

    public function getCountActivities(){
        $activities=collect();
        foreach($this->items as $item){
            if($item->activityItem && $item->activityItem->tracer == "SI"){
                $activities->add($item->activityItem);
            }
        }
        return count($activities->unique('int_code'));
    }

    public function itemsBy($type, $precision = false)
    {
        return $this->items
        ->where('workshop',$type == 'Workshop' ? '=' : '!=','SI')
        ->when($type != 'Workshop', function($q) use ($type){
            return $q->where('activity_type',$type == 'Indirect' ? '=' : '!=','Indirecta');
        })
        ->when($precision, function($q){
            return $q->filter(function($item){
                return $item->activityItem;
            });
        });
    }

    protected $casts = [
        'access' => 'array'
    ];
}