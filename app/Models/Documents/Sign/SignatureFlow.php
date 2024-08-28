<?php

namespace App\Models\Documents\Sign;

use App\Models\Documents\Signature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignatureFlow extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Punto de Partida en Y
     */
    const START_Y = 40;

    /**
     * Espaciado entre una linea y otra
     */
    const PADDING = 37;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sign_flows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_visator',
        'md5_file',
        'file',
        'column_position',
        'row_position',
        'status',
        'status_at',
        'rejected_observation',
        'signer_id',
        'original_signer_id',
        'signature_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status_at' => 'datetime'
    ];

    /**
     * Get the signer that owns the signature flow.
     *
     * @return BelongsTo
     */
    public function signer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the original signer that owns the signature flow.
     *
     * @return BelongsTo
     */
    public function originalSigner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the signature that owns the signature flow.
     *
     * @return BelongsTo
     */
    public function signature(): BelongsTo
    {
        return $this->belongsTo(Signature::class);
    }

    /**
     * Get the status color attribute.
     *
     * @return string
     */
    public function getStatusColorAttribute(): string
    {
        switch ($this->status) {
            case 'pending':
                $statusColor = 'default';
                break;

            case 'rejected':
                $statusColor = 'danger';
                break;

            case 'signed':
                $statusColor = 'success';
                break;
            default:
                $statusColor = 'dark';
                break;
        }

        return $statusColor;
    }

    /**
     * Get the status color text attribute.
     *
     * @return string
     */
    public function getStatusColorTextAttribute(): string
    {
        switch ($this->status) {
            case 'pending':
                $statusColor = 'dark';
                break;

            case 'rejected':
                $statusColor = 'white';
                break;

            case 'signed':
                $statusColor = 'white';
                break;
            default:
                $statusColor = 'white';
                break;
        }

        return $statusColor;
    }

    /**
     * Get the Y attribute.
     *
     * @return int
     */
    public function getYAttribute(): int
    {
        $padding = ($this->is_visator == true) ? 15 : SignatureFlow::PADDING;

        return SignatureFlow::START_Y + (($this->row_position) * $padding); // punto de inicio + (ancho de linea * posicion)
    }

    /**
     * Get the X attribute.
     *
     * @return int
     */
    public function getXAttribute(): int
    {
        switch ($this->column_position) {
            case 'left':
                $x = 33;
                break;
            case 'center':
                $x = 215;
                break;
            case 'right':
                $x = 397;
                break;
            default:
                $x = 0;
                break;
        }

        return $x;
    }
}