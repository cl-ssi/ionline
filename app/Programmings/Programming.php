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
        return $this->belongsTo('App\User');
    }

    public function items(){
        return $this->hasMany('App\Programmings\ProgrammingItem');
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

    public function countTotalNOTRectifiedReviews() {
        $total=0;
        foreach($this->items as $item){
            $total += $item->getCountNOTRectifiedReviews();
        }
        return $total;
    }

    public function getCountActivities(){
        $activities=collect();
        foreach($this->items as $item){
            if($item->activity_id != null){
                $activities->add($item->activityItem);
            }
        }
        return count($activities->unique('int_code'));
    }

    protected $casts = [
        'access' => 'array'
    ];
}