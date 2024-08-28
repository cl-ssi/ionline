<?php

namespace App\Models\Meetings;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Meeting extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meet_meetings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'correlative',
        'user_creator_id',
        'user_responsible_id',
        'ou_responsible_id',
        'establishment_id',
        'date',
        'type',
        'subject',
        'description',
        'mechanism',
        'start_at',
        'end_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'date' => 'date',
        // 'start_at' => 'datetime',
        // 'end_at' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user responsible for the meeting.
     *
     * @return BelongsTo
     */
    public function userResponsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_responsible_id')->withTrashed();
    }

    /**
     * Get the groupings for the meeting.
     *
     * @return HasMany
     */
    public function groupings(): HasMany
    {
        return $this->hasMany(Grouping::class);
    }

    /**
     * Get the commitments for the meeting.
     *
     * @return HasMany
     */
    public function commitments(): HasMany
    {
        return $this->hasMany(Commitment::class);
    }

    /**
     * Get the user creator for the meeting.
     *
     * @return BelongsTo
     */
    public function userCreator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_creator_id')->withTrashed();
    }

    /**
     * Get the file associated with the meeting.
     *
     * @return MorphOne
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * Get the status value attribute.
     *
     * @return string|null
     */
    public function getStatusValueAttribute(): ?string
    {
        $statuses = [
            'saved' => 'Guardado',
            'sgr'   => 'Derivado SGR',
        ];

        return $statuses[$this->status] ?? null;
    }

    /**
     * Get the type value attribute.
     *
     * @return string|null
     */
    public function getTypeValueAttribute(): ?string
    {
        $types = [
            'lobby'             => 'Lobby',
            'extraordinaria'    => 'Extraordinaria',
            'no extraordinaria' => 'No extraordinaria',
        ];

        return $types[$this->type] ?? null;
    }

    /**
     * Get the mechanism value attribute.
     *
     * @return string|null
     */
    public function getMechanismValueAttribute(): ?string
    {
        $mechanisms = [
            'videoconferencia' => 'Videoconferencia',
            'presencial'       => 'Presencial',
        ];

        return $mechanisms[$this->mechanism] ?? null;
    }

    /*
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($meeting) {
            //TODO: PARAMETRIZAR TYPE_ID VIATICOS
            $meeting->correlative = Correlative::getCorrelativeFromType(10, $allowance->organizationalUnitAllowance->establishment_id);
        });
    }
    */
}