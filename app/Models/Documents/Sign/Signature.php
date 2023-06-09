<?php

namespace App\Models\Documents\Sign;

use App\Models\Documents\Document;
use App\Models\Documents\Sign\SignatureAnnex;
use App\Models\Documents\Type;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

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
        'is_blocked',
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
        return $this->hasMany(SignatureFlow::class)->where('column_position', 'left')->orderby('row_position');
    }

    public function centerSignatures()
    {
        return $this->hasMany(SignatureFlow::class)->where('column_position', 'center')->orderby('row_position');
    }

    public function rightSignatures()
    {
        return $this->hasMany(SignatureFlow::class)->where('column_position', 'right')->orderby('row_position');
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

    public function canSign($signatureFlow)
    {
        if($this->typeByColumn($signatureFlow->column_position) == 'Opcional')
        {
            if($signatureFlow->status == 'signed') {
                $can = false;
            } else {
                $can = true;
            }
        }
        elseif($this->typeByColumn($signatureFlow->column_position) == 'Obligatorio sin Cadena de Responsabilidad')
        {
            if($signatureFlow->status == 'signed') {
                $can = false;
            } else {
                $can = true;
            }
        }
        elseif($this->typeByColumn($signatureFlow->column_position) == 'Obligatorio en Cadena de Responsabilidad')
        {
            $signers = $this->signersByColumn($signatureFlow->column_position);

            if($signatureFlow->row_position == 0)
            {
                $can = $signatureFlow->status == 'pending' ? true : false;
            }
            else
            {
                $signerPrevious = $signers->firstWhere('row_position', $signatureFlow->row_position - 1);

                $can = (isset($signerPrevious) && $signerPrevious->status == 'signed' && $signatureFlow->status == 'pending') ? true : false;
            }
        }

        return $can;
    }

    public function getCanSignatureAttribute()
    {
        $signatureFlow = $this->flows->firstWhere('signer_id', auth()->id());

        $position = $this->columnAvailable->search(function ($column) use($signatureFlow) {
            return $column == $signatureFlow->column_position;
        });

        if($position == 0)
        {
            return $this->canSign($signatureFlow);
        }
        else
        {
            if($this->columnAvailable->count() > 0)
            {
                $previous = $this->allSignedByColumn($this->columnAvailable->get($position - 1));
            }

            return  $previous && $this->canSign($signatureFlow);
        }
    }

    public function typeByColumn($columnPosition)
    {
        if($columnPosition == 'left')
        {
            $type = $this->column_left_endorse;
        }
        elseif($columnPosition == 'center')
        {
            $type = $this->column_center_endorse;

        }
        elseif($columnPosition == 'right')
        {
            $type = $this->column_right_endorse;
        }

        return $type;
    }

    public function signersByColumn($columnPosition)
    {
        if($columnPosition == 'left')
        {
            $signers = $this->leftSignatures;
        }
        elseif($columnPosition == 'center')
        {
            $signers = $this->centerSignatures;

        }
        elseif($columnPosition == 'right')
        {
            $signers = $this->rightSignatures;
        }

        return $signers;
    }

    public function allSignedByColumn($columnPosition)
    {
        if($columnPosition == 'left')
        {
            $allSigned = $this->leftAllSigned;
        }
        elseif($columnPosition == 'center')
        {
            $allSigned = $this->centerAllSigned;
        }
        elseif($columnPosition == 'right')
        {
            $allSigned = $this->rightAllSigned;
        }

        return $allSigned;
    }

    public function getCanSignAttribute()
    {
        /**
         * TODO: ¿Que pasa con el subrrogante?
         */

        $columnPosition = $this->flows->firstWhere('signer_id', auth()->id())->column_position;

        if($columnPosition == 'left')
        {
            $type = $this->column_left_endorse;
            $signers = $this->leftSignatures;
        }
        elseif($columnPosition == 'center')
        {
            $type = $this->column_center_endorse;
            $signers = $this->centerSignatures;

        }
        elseif($columnPosition == 'right')
        {
            $type = $this->column_right_endorse;
            $signers = $this->rightSignatures;
        }

        $statusByColum = $this->getStatusColumn($columnPosition);

        if($type == 'Opcional' OR $type == 'Obligatorio sin Cadena de Responsabilidad')
        {
            $canSign = $statusByColum;
        }
        elseif($type == 'Obligatorio en Cadena de Responsabilidad')
        {
            $signer = $signers->firstWhere('signer_id', auth()->id());

            if(!isset($signer))
                $canSign = false;

            if($signer->row_position == 0 && $signer->status == 'pending' && $statusByColum && $this->columnAvailable->first() )
                $canSign = true;
            else {
                $signerPrevious = $signers->firstWhere('row_position', $signer->row_position - 1);

                if(isset($signerPrevious) && $signerPrevious->status == 'signed' && $signer->status == 'pending') {
                    $canSign = true;
                } else {
                    $canSign = false;
                }
            }

        }

        return $canSign;
    }

    public function getIsSignedForMeAttribute()
    {
        $signedForMe = $this->flows->firstWhere('signer_id', auth()->id());

        if(isset($signedForMe) && $signedForMe->status == 'pending')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getIsReadyAttribute()
    {
        $last = $this->columnAvailable->last();

        if($last == 'left')
        {
            $isReady = $this->leftAllSigned;
        }
        elseif($last == 'center')
        {
            $isReady = $this->centerAllSigned;
        }
        elseif($last == 'right')
        {
            $isReady = $this->rightAllSigned;
        }

        return $isReady;
    }

    public function getCounterAttribute()
    {
        return $this->signatures->count();
    }

    public function getLinkSignedFileAttribute()
    {
        $link = null;
        if(Storage::disk('gcs')->exists($this->signed_file))
        {
            $link = Storage::disk('gcs')->url($this->signed_file);
        }

        return $link;
    }

    public function getLinkFileAttribute()
    {
        $link = null;
        if(Storage::disk('gcs')->exists($this->file))
        {
            $link = Storage::disk('gcs')->url($this->file);
        }

        return $link;
    }

    public function getTypesAttribute()
    {
        $types = collect();
        $types->push($this->column_left_endorse);
        $types->push($this->column_center_endorse);
        $types->push($this->column_right_endorse);

        return $types;
    }

    public function getCountColumnAvailableAttribute()
    {
        return $this->leftSignatures->count() + $this->centerSignatures->count() + $this->rightSignatures->count();
    }

    public function getColumnAvailableAttribute()
    {
        $available = collect();

        if($this->leftSignatures->count() > 0)
        {
            $available->push('left');
        }

        if($this->centerSignatures->count() > 0)
        {
            $available->push('center');
        }

        if($this->rightSignatures->count() > 0)
        {
            $available->push('right');
        }

        return $available;
    }

    public function getColumnLeftSignatureStatusAttribute()
    {
        return $this->getStatusColumn('left');
    }

    public function getColumnCenterSignatureStatusAttribute()
    {
        return $this->getStatusColumn('center');
    }

    public function getColumnRightSignatureStatusAttribute()
    {
        return $this->getStatusColumn('right');
    }

    public function getStatusColumn($columParameter)
    {
        $position = $this->columnAvailable->search(function ($column) use ($columParameter) {
            return $column == $columParameter;
        });

        if($position == 0)
        {
            $available = true;
        }
        else
        {
            $columnAvailable = $this->columnAvailable->toArray();

            switch ($columnAvailable[$position - 1]) {
                case 'left':
                    $available = $this->leftAllSigned;
                    break;

                case 'center':
                    $available = $this->centerAllSigned;
                    break;

                case 'right':
                    $available = $this->rightAllSigned;
                    break;

                default:
                    $available = false;
                    break;
            }
        }

        return $available;
    }

    public function getLeftAllSignedAttribute()
    {
        if($this->column_left_endorse == 'Opcional')
        {
            return true;
        }

        return $this->leftSignatures->every('status', '==', 'signed');
    }

    public function getCenterAllSignedAttribute()
    {
        if($this->column_center_endorse == 'Opcional')
        {
            return true;
        }

        return $this->centerSignatures->every('status', '==', 'signed');
    }

    public function getRightAllSignedAttribute()
    {
        if($this->column_right_endorse == 'Opcional')
        {
            return true;
        }

        return $this->rightSignatures->every('status', '==', 'signed');
    }

    public function getSignedByAllAttribute()
    {
        $signedByColumn = collect();

        if($this->leftSignatures->count() > 0)
        {
            $signedByColumn->push($this->allSignedByColumn('left'));
        }

        if($this->centerSignatures->count() > 0)
        {
            $signedByColumn->push($this->allSignedByColumn('center'));
        }

        if($this->rightSignatures->count() > 0)
        {
            $signedByColumn->push($this->allSignedByColumn('right'));
        }

        return $signedByColumn->every(function($item) {
            return $item == true;
        });
    }

    public function getLeftVisatorClassAttribute()
    {
        return $this->visatorClass($this->column_left_visator);
    }

    public function getCenterVisatorClassAttribute()
    {
        return $this->visatorClass($this->column_center_visator);
    }

    public function getRightVisatorClassAttribute()
    {
        return $this->visatorClass($this->column_right_visator);
    }

    public function isAuthCreator()
    {
        return $this->user_id == auth()->id();
    }

    public function visatorClass($column)
    {
        return ($column == true) ? 'text-lowercase' : 'text-uppercase';
    }

    public function getLeftBorderEndorseAttribute()
    {
        return $this->endorseBorderColumn($this->column_left_endorse);
    }

    public function getCenterBorderEndorseAttribute()
    {
        return $this->endorseBorderColumn($this->column_center_endorse);
    }

    public function getRightBorderEndorseAttribute()
    {
        return $this->endorseBorderColumn($this->column_right_endorse);
    }

    public function endorseBorderColumn($endorse)
    {
        switch ($endorse) {
            case 'Obligatorio en Cadena de Responsabilidad':
                return 'border-en-cadena';
                break;

            case 'Obligatorio sin Cadena de Responsabilidad':
                return 'border-sin-cadena';
                break;

            case 'Opcional':
                return 'border-opcional';
                break;
        }
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

    public static function modoDesatendidoProduccion()
    {
        return 3;
    }

    public function calculateTop($linkDocument)
    {
        /**
         * Obtiene el ancho y largo del pdf
         */
        $fileContent = file_get_contents($linkDocument);
        $pdf = new Fpdi('P', 'mm');
        $pdf->setSourceFile(StreamReader::createByString($fileContent));
        $firstPage = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($firstPage);

        /**
         * Calculo de milimetros a centimetros
         */
        $widthFile = $size['width'] / 10;
        $heightFile = $size['height'] / 10;

        /**
         * Calculo de centimetros a pulgadas y cada pulgada son 72 ppp (dots per inch - dpi)
         */
        $xCoordinate = ($widthFile * 0.393701) * 72;
        $yCoordinate = ($heightFile * 0.393701) * 72;

        /**
         * Descifrar porque hay que restar 220 y 135 a las coordenadas
         */
        $coordinate['x'] = $xCoordinate - 220;
        $coordinate['y'] = $yCoordinate - 90;

        return $coordinate;
    }

    public function calculateRow($position, $isVisator = false)
    {
        $padding = ($isVisator == true) ? 15 : SignatureFlow::PADDING;

        return SignatureFlow::START_Y + (($position - 1) * $padding) ; // punto de inicio + (ancho de linea * posicion)
    }

    public function calculateColumn($position)
    {
        switch ($position)
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

    public static function getFolder()
    {
        return 'ionline/sign/original';
    }

    public static function getFolderSigned()
    {
        return 'ionline/sign/signed/';
    }

    public static function getFolderEnumerate()
    {
        return 'ionline/sign/enumerate';
    }

    public static function getFolderAnnexes()
    {
        return 'ionline/sign/annexes';
    }

    public static function getVerificationCode(Signature $signature)
    {
        return $signature->id . "-" . Str::random(6);
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
            case Signature::modoDesatendidoProduccion():
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
                $entity = 'Servicio de Salud Iquique';
                break;
            case Signature::modoAtendidoTest():
                $entity = 'Subsecretaría General de La Presidencia';
                $entity = 'Servicio de Salud Iquique';
                break;
            case Signature::modoAtendidoProduccion():
                $entity = 'Servicio de Salud Iquique';
                break;
            case Signature::modoDesatendidoProduccion():
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
                $purpose = 'Propósito General';
                $purpose = 'Desatendido';
                break;
            case Signature::modoAtendidoProduccion():
                $purpose = 'Propósito General';
                break;
            case Signature::modoDesatendidoProduccion():
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
                $run = 15287582;
                break;
            case Signature::modoAtendidoTest():
                $run = 11111111;
                $run = '15287582';
                break;
            case Signature::modoAtendidoProduccion():
                $run = $runParameter;
                break;
            case Signature::modoDesatendidoProduccion():
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

    public function getData($document, $jwt, $signatureBase64, $apiToken, $xCoordinate, $yCoordinate, $page = 'LAST')
    {
        $base64Pdf = base64_encode(file_get_contents($document));

        $checkSumPdf = md5_file($document);

        return [
            'api_token_key' => $apiToken,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => $base64Pdf,
                    'description' => 'str',
                    'checksum' => $checkSumPdf,
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"2\">
                                        <llx>" . ($xCoordinate). "</llx>
                                        <lly>" . ($yCoordinate). "</lly>
                                        <urx>" . ($xCoordinate + (175)) . "</urx>
                                        <ury>" . ($yCoordinate + 35) . "</ury>
                                        <page>" . $page . "</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$signatureBase64</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];
    }
}
