<?php

namespace App\Models\Documents\Sign;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignatureFlow extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Punto de Partida en Y
     */
    const START_Y = 2;

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
        'signature_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'status_at',
    ];

    public function signer()
    {
        return $this->belongsTo(User::class);
    }

    public function originalSigner()
    {
        return $this->belongsTo(User::class);
    }

    public function signature()
    {
        return $this->belongsTo(Signature::class);
    }

    public function getStatusColorAttribute()
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

    public function getStatusColorTextAttribute()
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

    public function getYAttribute()
    {
        $padding = ($this->is_visator == true) ? 15 : SignatureFlow::PADDING;

        return SignatureFlow::START_Y + (($this->row_position) * $padding) ; // punto de inicio + (ancho de linea * posicion)
    }

    public function getXAttribute()
    {
        switch ($this->column_position)
        {
            case 'left':
                $x = 33;
                break;
            case 'center':
                $x = 215;
                break;
            case 'right':
                $x = 397;
                break;
        }

        return $x;
    }
}
