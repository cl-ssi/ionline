<?php

namespace App\Models\Requirements;

use App\Models\Documents\Parte;
use App\Models\Requirements\Category;
use App\Models\Requirements\Event;
use App\Models\Requirements\EventStatus;
use App\Models\Requirements\Label;
use App\Models\Requirements\LabelRequirement;
use App\Models\Requirements\RequirementStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Requirement extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'req_requirements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'subject',
        'priority',
        'status',
        'limit_at',
        'user_id',
        'parte_id',
        'group_number',
        'to_authority',
        'category_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'limit_at' => 'date',
    ];

    /**
     * Get the events for the requirement.
     *
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the events without CC for the requirement.
     *
     * @return HasMany
     */
    public function eventsWithoutCC(): HasMany
    {
        return $this->hasMany(Event::class)->where('status', '<>', 'en copia');
    }

    /**
     * Get the CC events for the requirement.
     *
     * @return HasMany
     */
    public function ccEvents(): HasMany
    {
        return $this->hasMany(Event::class)->where('status', 'en copia');
    }

    /**
     * Get the user that owns the requirement.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the parte that owns the requirement.
     *
     * @return BelongsTo
     */
    public function parte(): BelongsTo
    {
        return $this->belongsTo(Parte::class);
    }

    /**
     * Get the labels for the requirement.
     *
     * @return BelongsToMany
     */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'req_labels_requirements');
    }

    /**
     * Get the category that owns the requirement.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the first event for the requirement.
     *
     * @return HasOne
     */
    public function firstEvent(): HasOne
    {
        return $this->hasOne(Event::class)->where('status', 'creado');
    }

    /**
     * Get the viewed events for the requirement.
     *
     * @return HasMany
     */
    public function eventsViewed(): HasMany
    {
        return $this->hasMany(EventStatus::class)->where('user_id', auth()->id());
    }


    /**
     * // FIXME: viewed hace referencia a los archivados y no a los vistos
     */
    /**
     * Get the archived statuses for the requirement.
     *
     * @return HasMany
     */
    public function archived(): HasMany
    {
        return $this->hasMany(RequirementStatus::class)->where('status', 'viewed');
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('id','LIKE','%'.$request.'%')
                  ->OrWhere('subject','LIKE','%'.$request.'%');
        }

        return $query;
    }

    /** 
     * // FIXME: no debería llamarse RequirementStatus, status directamente 
     * sin embargo esa popiedad ya existe
     */
    /**
     * Get the requirement statuses for the requirement.
     *
     * @return HasMany
     */
    public function requirementStatus(): HasMany
    {
        return $this->hasMany(RequirementStatus::class);
    }

    public static function getNextGroupNumber() {
        $lastReqWithGroupNumber = Requirement::whereNotNull('group_number')
            ->latest()
            ->first();

        if($lastReqWithGroupNumber) {
            return $lastReqWithGroupNumber->group_number + 1;
        }
        else {
            return 1;
        }
    }

    /** Setea las labels de un requerimiento en base a un array de ids de labels */
    public function setLabels($labels) {
        if(is_array($labels)){
            foreach($labels as $label) {
                LabelRequirement::create([
                    'user_id' => auth()->id(),
                    'requirement_id' => $this->id,
                    'label_id' => $label,
                ]);
            }
        }
    }

    public function getSetEventsAsViewedAttribute() {
        $eventsWithoutCC = $this->eventsWithoutCC->pluck('id')->toArray();
        $eventsViewed = $this->eventsViewed->pluck('id')->toArray();

        foreach($eventsWithoutCC as $event)
        {
            if(!in_array($event,$eventsViewed))
            {
                $eventStatus = EventStatus::create([
                    'event_id' => $event,
                    'user_id' => auth()->id(),
                    'requirement_id' => $this->id,
                    'status' => 'viewed'
                ]);
            }
        }
    }

    public function getUnreadedEventsAttribute(){
        $ct = $this->eventsWithoutCC->count() - $this->eventsViewed->count();
        return ($ct > 0) ? $ct : null;
    }

    /**
     * Obtiene los requirements marcados "como enviados al manager (to_authority)" de sus UO
     * @param $query
     * @param $secretaryOuIds
     * @param $users
     * @param $getArchived
     * @return mixed
     */
    public function scopeGetSentToAuthority($query, $secretaryOuIds, $users, $getArchived)
    {
        $query->orWhere('to_authority', true)
            ->where(function ($query) use ($secretaryOuIds) {
                $query->whereHas('events', function ($query) use ($secretaryOuIds) {
                    $query->where('to_authority', true)
                        ->whereIn('to_ou_id', $secretaryOuIds);
                });
            })->when($getArchived, function ($query) use ($users) {
                $query->whereHas('RequirementStatus', function ($query) use ($users) {
                    $query->where('status', 'viewed')
                        ->whereIn('user_id', $users);
                });
            });

        return $query;
    }

    public static function getPendingRequirements()
    {
        $users[0] = auth()->id();
        $ous_secretary = [];
        //   14/06/2022: Esteban Rojas - Quitar requerimientos como secretaria (Se creó una nueva bandeja para ello)
        //   $ous_secretary = Authority::getAmIAuthorityFromOu(today(),'secretary', auth()->id());
        //   foreach($ous_secretary as $secretary){
        //     if (Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')) {
        //       $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')->user_id;
        //     }
        //   }

        $archived_requirements = Requirement::with('events')
                                ->whereHas('events', function ($query) use ($users) {
                                        $query->whereIn('from_user_id',$users)
                                            ->orWhereIn('to_user_id',$users);
                                })->whereHas('RequirementStatus', function ($query) use ($users) {
                                        $query->where('status','viewed')
                                            ->whereIn('user_id',$users);
                                })->count();

        $created_requirements = Requirement::whereHas('events', function ($query) use ($users) {
                                    $query->whereIn('from_user_id',$users)
                                            ->orWhereIn('to_user_id',$users);
                                })
                                ->count();

        $total = $created_requirements - $archived_requirements;

        if($total > 0)
        {
            return $total;
        }
    }
}
