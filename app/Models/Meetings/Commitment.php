<?php

namespace App\Models\Meetings;

use App\Models\Requirements\Requirement;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Commitment extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description',
        'type',
        'commitment_user_id',
        'commitment_ou_id',
        'priority',
        'closing_date',
        'meeting_id',
        'requirement_id',
        'user_id'
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function commitmentUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commitment_user_id')->withTrashed();
    }

    public function commitmentOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'commitment_ou_id')->withTrashed();
    }

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $cast = [
        'closing_date' => 'date:Y-m-d',
    ];

    protected $table = 'meet_commitments';

}
