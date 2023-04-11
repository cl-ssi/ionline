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

    public static function getFolder()
    {
        return 'ionline/sign/original';
    }

    public function makePayload($purpose, $run)
    {
        $entity = 'Subsecretaría General de La Presidencia';

        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
            "run" => $run
        ];

        return $payload;
    }

    public static function getUrl($modo)
    {
        switch ($modo)
        {
            case 0:
                $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
                break;
            case 1:
                $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
                break;
            case 2:
                $url = env('FIRMA_URL');
                break;
            case 3:
                $url = env('FIRMA_URL');
                break;
            default:
                $url = null;
                break;
        }
        return $url;
    }

    public function getEntity($modo)
    {
        switch ($modo)
        {
            case 0:
                $entity = 'Subsecretaría General de La Presidencia';
                break;
            case 1:
                $entity = 'Subsecretaría General de La Presidencia';
                break;
            case 2:
                $entity = 'Servicio de Salud Iquique';
                break;
            case 3:
                $entity = 'Servicio de Salud Iquique';
                break;
            default:
                $entity = null;
                break;
        }
        return $entity;
    }

    public function getPurpose($modo)
    {
        switch ($modo)
        {
            case 0:
                $purpose = 'Desatendido';
                break;
            case 1:
                $purpose = 'Propósito General';
                break;
            case 2:
                $purpose = 'Propósito General';
                break;
            case 3:
                $purpose = 'Desatendido';
                break;
            default:
                $purpose = null;
                break;
        }
        return $purpose;
    }
}
