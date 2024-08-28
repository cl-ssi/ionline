<?php

namespace App\Models\ReplacementStaff;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestSign extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_request_signs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'ou_alias',
        'organizational_unit_id',
        'request_id',
        'request_status',
        'observation',
        'date_sign',
        'request_replacement_staff_id'
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
     * Get the request replacement staff that owns the request sign.
     *
     * @return BelongsTo
     */
    public function requestReplacementStaff(): BelongsTo
    {
        return $this->belongsTo(RequestReplacementStaff::class);
    }

    /**
     * Get the organizational unit that owns the request sign.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the user that owns the document.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the status value attribute.
     *
     * @return string
     */
    public function getStatusValueAttribute(): string
    {
        switch ($this->request_status) {
            case 'pending':
                return 'Pendiente';
            case 'accepted':
                return 'Aprobado';
            case 'rejected':
                return 'Rechazado';
            default:
                return '';
        }
    }
}