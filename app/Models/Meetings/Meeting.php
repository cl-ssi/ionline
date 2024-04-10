<?php

namespace App\Models\Meetings;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\File;

class Meeting extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

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
        'mechanism',
        'start_at',
        'end_at',
        // 'file'
    ];

    public function userResponsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_responsible_id')->withTrashed();
    }

    public function groupings(): HasMany
    {
        return $this->hasMany(Grouping::class);
    }

    public function commitments(): HasMany
    {
        return $this->hasMany(Commitment::class);
    }

    public function userCreator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_creator_id')->withTrashed();
    }

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function getStatusValueAttribute()
    {
        $statuses = [
            'saved' => 'Guardado',
            'sgr'   => 'Derivado SGR',
        ];

        return $statuses[$this->status] ?? null;
    }

    public function getTypeValueAttribute()
    {
        $types = [
            'lobby'             => 'Lobby',
            'extraordinaria'    => 'Extraordinaria',
            'no extraordinaria' => 'No extraordinaria',
        ];

        return $types[$this->type] ?? null;
    }

    public function getMechanismValueAttribute()
    {
        $mechanisms = [
            'videoconferencia' => 'Videoconferencia',
            'presencial'       => 'Presencial',
        ];

        return $mechanisms[$this->mechanism] ?? null;
    }

    /*
    protected $dates = [
        'date'
    ];
    */

    // protected $casts = [
    //     'date'     => 'date',
    //     'start_at' => 'datetime',
    //     'end_at'   => 'datetime'
    // ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

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

    protected $table = 'meet_meetings';
}
