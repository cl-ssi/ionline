<?php

namespace App\Models\Programmings;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Programming extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'pro_programmings';
    protected $fillable = [
        'id','year', 'description', 'access', 'status'
    ];

    /**
     * Get the user that owns the document.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function items(){
        return $this->hasMany('App\Models\Programmings\ProgrammingItem')->orderBy('activity_id', 'ASC');
    }

    public function programmingDay(){
        return $this->hasOne('App\Models\Programmings\ProgrammingDay');
    }

    public function emergencies(){
        return $this->hasMany('App\Models\Programmings\Emergency');
    }

    public function professionalHours(){
        return $this->hasMany('App\Models\Programmings\ProfessionalHour');
    }

    /**
     * Get the establishment that owns the place.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function pendingItems(){
        return $this->belongsToMany(ActivityItem::class, 'pro_programming_activity_item')->withPivot('id', 'requested_by', 'observation')->whereNull('pro_programming_activity_item.deleted_at')->withTimestamps()->using(ProgrammingActivityItem::class);
    }

    public function getPendingIndirectItemsAttribute(){
        return ProgrammingActivityItem::where('programming_id', $this->id)->whereNull('activity_item_id')->whereNull('deleted_at')->get();
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
            if($item->activityItem && $item->activityItem->int_code != null && $item->activityItem->tracer == "SI"){
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

    public function itemsIndirectBy($subtype)
    {
        return $this->items->where('activity_type','Indirecta')->where('activity_subtype', $subtype);
    }

    public function getValueAcumSinceScheduled($type, $professional_hour_id, $activities)
    {
        $total = 0;
        foreach($this->items as $item)
            if(in_array($item->activity_type, $activities))
                $total += $item->professionalHours->where('id', $professional_hour_id)->sum('pivot.'.$type);
        return $total;
    }

    public function getHoursYearAcumByPrapFinanced($answer, $professional_hour_id)
    {
        $total = 0;
        foreach($this->items as $item)
            if($item->prap_financed == $answer)
                $total += $item->professionalHours->where('id', $professional_hour_id)->sum('pivot.hours_required_year');
        return $total;
    }

    protected $casts = [
        'access' => 'array'
    ];
}