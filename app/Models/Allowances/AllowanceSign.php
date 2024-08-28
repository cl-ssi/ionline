<?php

namespace App\Models\Allowances;

use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class AllowanceSign extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alw_allowance_signs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'ou_alias',
        'organizational_unit_id',
        'status',
        'observation',
        'date_sign'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_sign' => 'datetime'
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
     * Get the user that owns the allowance sign.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the organizational unit that owns the allowance sign.
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'organizational_unit_id');
    }

    /**
     * Get the allowance that owns the allowance sign.
     */
    public function allowance(): BelongsTo
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }

    /**
     * Get the next sign.
     */
    public function getNextSign()
    {
        $nextSign = AllowanceSign::where('allowance_id', $this->allowance_id)
            ->where('position', $this->position + 1)
            ->first();

        return $nextSign;
    }

    /**
     * Get the status value attribute.
     */
    public function getStatusValueAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Pendiente de Aprobación';
            case 'accepted':
                return 'Aceptada';
            case 'rejected':
                return 'Rechazada';
        }
    }
}