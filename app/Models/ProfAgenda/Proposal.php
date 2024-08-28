<?php

namespace App\Models\ProfAgenda;

use App\Models\Parameters\Profession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Proposal extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prof_agenda_proposals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'user_id',
        'profession_id',
        'start_date',
        'end_date',
        'status',
        'observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the profession associated with the proposal.
     *
     * @return BelongsTo
     */
    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    /**
     * Get the employee associated with the proposal.
     *
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the details associated with the proposal.
     *
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(ProposalDetail::class);
    }
}
