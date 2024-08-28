<?php

namespace App\Models\Requirements;

use App\Models\Documents\Document;
use App\Models\Requirements\EventStatus;
use App\Models\Requirements\File;
use App\Models\Requirements\Requirement;
use App\Models\Rrhh\Authority;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'req_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'status',
        'from_user_id',
        'from_ou_id',
        'to_user_id',
        'to_ou_id',
        'requirement_id',
        'limit_at',
        'to_authority'
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
     * // FIXME: la relacion fromUser no deberia ser from_user
     * Get the user that sent the event.
     *
     * @return BelongsTo
     */
    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id')->withTrashed();
    }

    /**
     * Get the organizational unit that sent the event.
     *
     * @return BelongsTo
     */
    public function from_ou(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'from_ou_id')->withTrashed();
    }

    /**
     * Get the user that received the event.
     *
     * @return BelongsTo
     */
    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id')->withTrashed();
    }

    /**
     * Get the organizational unit that received the event.
     *
     * @return BelongsTo
     */
    public function to_ou(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'to_ou_id')->withTrashed();
    }

    /**
     * Get the requirement that owns the event.
     *
     * @return BelongsTo
     */
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    /**
     * Get the files for the event.
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Get the event statuses for the event.
     *
     * @return HasMany
     */
    public function eventStatus(): HasMany
    {
        return $this->hasMany(EventStatus::class);
    }

    /**
     * Get the viewed status for the event.
     *
     * @return HasOne
     */
    public function viewed(): HasOne
    {
        return $this->hasOne(EventStatus::class)->where('user_id', auth()->id());
    }

    /**
     * Get the documents for the event.
     *
     * @return BelongsToMany
     */
    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'req_documents_events');
    }

    /**
     * Get the creation date of the event.
     *
     * @return string
     */
    public function getCreationDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    /**
     * Revisa si el evento fue enviado a una autoridad tipo manager de la ou de destino
     *
     * @return bool
     */
    public function isSentToAuthority(): bool
    {
        $authorities = Authority::getAmIAuthorityFromOu($this->created_at, 'manager', $this->to_user_id);

        foreach ($authorities as $authority) {
            if ($authority->organizational_unit_id == $this->to_ou_id) {
                return true;
            }
        }

        return false;
    }
}