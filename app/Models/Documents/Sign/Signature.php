<?php

namespace App\Models\Documents\Sign;

use App\Models\Documents\Sign\SignatureAnnex;
use App\Models\Documents\Type;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signature extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sign_signatures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_number',
        'type_id',
        'reserved',
        'subject',
        'description',
        'file',
        'distribution',
        'recipients',
        'status',
        'status_at',
        'verification_code',
        'signed_file',
        'page',
        'column_left_visator',
        'column_left_endorse',
        'column_center_visator',
        'column_center_endorse',
        'column_right_visator',
        'column_right_endorse',
        'user_id',
        'ou_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'status_at',
        'document_number',
    ];

    public function flows()
    {
        return $this->hasMany(SignatureFlow::class);
    }

    public function leftSignatures()
    {
        return $this->hasMany(SignatureFlow::class)->where('column_position', 'left');
    }

    public function centerSignatures()
    {
        return $this->hasMany(SignatureFlow::class)->where('column_position', 'center');
    }

    public function rightSignatures()
    {
        return $this->hasMany(SignatureFlow::class)->where('column_position', 'right');
    }

    public function annexes()
    {
        return $this->hasMany(SignatureAnnex::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'uo_id');
    }
}
