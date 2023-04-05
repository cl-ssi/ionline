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
}
