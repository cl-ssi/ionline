<?php

namespace App\Models\Profile;

use App\Enums\Rrhh\AuthorityType;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subrogation extends Model
{
    use HasFactory;

    const TYPE_MANAGER = 'manager';
    const TYPE_SECRETARY = 'secretary';
    const TYPE_DELEGATE = 'delegate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subrogant_id',
        'level',
        'organizational_unit_id',
        'type',
        'active',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'rrhh_subrogations';

    protected $casts = [
        'active' => 'boolean',
        'type' => AuthorityType::class,
    ];

    public function user(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function subrogant(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'subrogant_id')->withTrashed();
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }
}
