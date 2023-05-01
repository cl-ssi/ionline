<?php

namespace App\Models\Documents\Sign;

use App\Models\Documents\Sign\SignatureAnnex;
use App\Models\Documents\Type;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'number',
        'enumerate_at',
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
        'is blocked',
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
        'enumerate_at',
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

    public function isEnumerate()
    {
        return $this->number != null;
    }

    public function isPending()
    {
        return $this->status == 'pending';
    }

    public function isCompleted()
    {
        return $this->status == 'completed';
    }

    public function isRejected()
    {
        return $this->status == 'rejected';
    }

    public function getStatusTranslateAttribute()
    {
        switch ($this->status) {
            case 'pending':
                $statusColor = 'pendiente';
                break;

            case 'rejected':
                $statusColor = 'rechazado';
                break;

            case 'completed':
                $statusColor = 'completado';
                break;
            default:
                $statusColor = 'desconocido';
                break;
        }
        return $statusColor;
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                $statusColor = 'warning';
                break;

            case 'rejected':
                $statusColor = 'danger';
                break;
            case 'completed':
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

            case 'completed':
                $statusColor = 'white';
                break;
            default:
                $statusColor = 'white';
                break;
        }
        return $statusColor;
    }

    public function getSignaturesAttribute()
    {
        $leftSignatures = $this->leftSignatures->sortBy('row_position');
        $centerSignatures = $this->centerSignatures->sortBy('row_position');
        $rightSignatures = $this->rightSignatures->sortBy('row_position');

        return $leftSignatures->merge($centerSignatures)->merge($rightSignatures);
    }

    public function getNextFlowAttribute()
    {
        $next = $this->signatures->search(function ($firm) {
            return $firm->status == 'pending';
        });

        return $this->signatures[$next];
    }

    public function getNextSignerAttribute()
    {
        $next = $this->signatures->search(function ($firm) {
            return $firm->status == 'pending';
        });

        if($this->nextFlow->status == 'pending')
            return $this->signatures[$next]->signer;
        else
            return null;
    }

    public function getCanSignAttribute()
    {
        if($this->nextFlow->column_position == 'left')
        {
            $type = $this->column_left_endorse;
        }
        elseif($this->nextFlow->column_position == 'center')
        {
            $type = $this->column_center_endorse;
        }
        elseif($this->nextFlow->column_position == 'right')
        {
            $type = $this->column_right_endorse;
        }

        if($type == 'Opcional')
        {
            $canSign = true;
        }
        elseif($type == 'Obligatorio sin Cadena de Responsabilidad')
        {
            $canSign = true;
        }
        elseif($type == 'Obligatorio en Cadena de Responsabilidad')
        {
            /**
             * TODO: ¿Que pasa con el subrrogante?
             */
            $canSign = $this->nextSigner ? $this->nextSigner->id == auth()->id() : false;
        }

        return $canSign;
    }

    public function getisSignedForMeAttribute()
    {
        $signedForMe = $this->flows->firstWhere('signer_id', auth()->id());

        if(isset($signedForMe) && $signedForMe->status == 'pending' )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getCounterAttribute()
    {
        return $this->signatures->count();
    }

    public function getLinkAttribute()
    {
        $link = null;
        if(Storage::disk('gcs')->exists($this->file))
        {
            $link = Storage::disk('gcs')->url($this->file);
        }

        return $link;
    }

    public static function getFolder()
    {
        return 'ionline/sign/original';
    }

    public static function getFolderSigned()
    {
        return 'ionline/sign/signed';
    }

    public static function getFolderEnumerate()
    {
        return 'ionline/sign/enumerate';
    }

    public static function getVerificationCode(Signature $signature)
    {
        return $signature->id . "-" . Str::random(6);
    }

    public static function modoDesatendidoTest()
    {
        return 0;
    }

    public static function modoAtendidoTest()
    {
        return 1;
    }

    public static function modoAtendidoProduccion()
    {
        return 2;
    }

    public static function modoDesatenidodProduccion()
    {
        return 3;
    }

    public function getUrl($modo)
    {
        switch ($modo)
        {
            case Signature::modoDesatendidoTest():
                $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
                break;
            case Signature::modoAtendidoTest():
                $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
                break;
            case Signature::modoAtendidoProduccion():
                $url = env('FIRMA_URL');
                break;
            case Signature::modoDesatenidodProduccion():
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
            case Signature::modoDesatendidoTest():
                $entity = 'Subsecretaría General de La Presidencia';
                break;
            case Signature::modoAtendidoTest():
                // $entity = 'Subsecretaría General de La Presidencia';
                $entity = 'Servicio de Salud Iquique';
                break;
            case Signature::modoAtendidoProduccion():
                $entity = 'Servicio de Salud Iquique';
                break;
            case Signature::modoDesatenidodProduccion():
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
            case Signature::modoDesatendidoTest():
                $purpose = 'Desatendido';
                break;
            case Signature::modoAtendidoTest():
                // $purpose = 'Propósito General';
                $purpose = 'Desatendido';
                break;
            case Signature::modoAtendidoProduccion():
                $purpose = 'Propósito General';
                break;
            case Signature::modoDesatenidodProduccion():
                $purpose = 'Desatendido';
                break;
            default:
                $purpose = null;
                break;
        }
        return $purpose;
    }

    public function getRun($modo, $runParameter)
    {
        switch ($modo)
        {
            case Signature::modoDesatendidoTest():
                $run = 22222222;
                break;
            case Signature::modoAtendidoTest():
                // $run = 11111111;
                $run = '15287582';
                break;
            case Signature::modoAtendidoProduccion():
                $run = $runParameter;
                break;
            case Signature::modoDesatenidodProduccion():
                $run = $runParameter;
                break;
            default:
                $run = null;
                break;
        }
        return $run;
    }

    public function getPayload($modo, $run)
    {
        $purpose = app(Signature::class)->getPurpose($modo);
        $entity = app(Signature::class)->getEntity($modo);
        $run = app(Signature::class)->getRun($modo, $run);

        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "run" => $run,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
        ];

        return $payload;
    }
}
