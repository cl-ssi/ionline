<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\User;
use App\Models\Rrhh\Authority;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Parameters\Estament;
use App\Models\Trainings\StrategicAxis;
use App\Models\Trainings\ImpactObjective;
use App\Models\Documents\Approval;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class IdentifyNeed extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status',

        // USUARIO
        'user_id',
        'organizational_unit_id',
        'organizational_unit_name',
        'establishment_id',
        'establishment_name',
        'email',
        'email_personal',
        'position',

        // JEFATURA
        'boss_id',
        'boss_email',

        'subject',
        'estament_id',
        'family_position',
        'nature_of_the_need',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
        'law',
        'question_5',
        'question_6',
        'training_type',
        'other_training_type',
        'strategic_axis_id',
        'impact_objective_id',
        'mechanism',
        'places',

        // TIPO ONLINE
        'online_type_mechanism',

        // TIPO PRESENCIAL
        'coffee_break',
        'coffee_break_price',

        // TIPO ONLINE ASINCRONICO 
        'exists',
        'digital_capsule',

        'transport',
        'transport_price',
        'accommodation',
        'accommodation_price'
    ];

    /**
     * Get the user that owns the identify need.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
       return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the organizational unit that created the identify need.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class)->withTrashed();
    }

    /**
     * Get the boss of the user who owns the identification need.
     *
     * @return BelongsTo
     */
    public function bossUser(): BelongsTo
    {
       return $this->belongsTo(User::class, 'boss_id')->withTrashed();
    }

    /**
     * Get the estament that owns the identify need.
     *
     * @return BelongsTo
     */
    public function estament(): BelongsTo
    {
        return $this->belongsTo(Estament::class);
    }

    /**
     * Get the strategic axis that owns the identify need.
     *
     * @return BelongsTo
     */
    public function strategicAxis(): BelongsTo 
    {
        return $this->belongsTo(StrategicAxis::class);
    }

    /**
     * Get the estament that owns the identify need.
     *
     * @return BelongsTo
     */
    public function impactObjective(): BelongsTo
    {
        return $this->belongsTo(ImpactObjective::class);
    }

    /**
     * Get all of the ModificationRequest's approvations.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    /**
     * Get the status value attribute.
     *
     * @return string|null
     */
    public function getStatusValueAttribute(): ?string
    {
        $statuses = [
            'saved'     => 'Guardado',
            'pending'   => 'Pendiente',
        ];

        return $statuses[$this->status] ?? null;
    }

    /**
     * Get the exists boolean value attribute.
     *
     */
    public function getExistsLabelAttribute()
    {
        return $this->exists === null 
            ? '' 
            : ($this->exists ? 'Sí' : 'No');
    }

    /**
     * Get the digital capsule boolean value attribute.
     *
     */
    public function getDigitalCapsuleLabelAttribute()
    {
        return $this->digital_capsule === null 
            ? '' 
            : ($this->digital_capsule ? 'Sí' : 'No');
    }

    /**
     * Get the digital capsule boolean value attribute.
     *
     */
    public function getCoffeeBreakLabelAttribute()
    {
        return $this->coffee_break === null 
            ? 'No' 
            : ($this->coffee_break ? 'Sí' : 'No');
    }

    /**
     * Define eventos del modelo.
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            // Convierte el array a JSON si es un array
            if (is_array($model->nature_of_the_need)) {
                $model->nature_of_the_need = json_encode($model->nature_of_the_need);
            }

            // Convierte 'law' a JSON si es un array
            if (is_array($model->law)) {
                $model->law = json_encode($model->law);
            }
        });
    }

    public function getNatureOfTheNeedAttribute($value)
    {
        return json_decode($value, true); // Convierte el string JSON en un array
    }

    public function setNatureOfTheNeedAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['nature_of_the_need'] = json_encode($value); // Serializa el array a JSON
        } elseif (is_string($value)) {
            $this->attributes['nature_of_the_need'] = $value; // Si ya es un JSON, lo guarda tal cual
        }
    }

    public function getLawAttribute($value)
    {
        return json_decode($value, true); // Convierte el string JSON en un array
    }

    public function setLawAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['law'] = json_encode($value); // Serializa el array a JSON
        } elseif (is_string($value)) {
            $this->attributes['law'] = $value; // Si ya es un JSON, lo guarda tal cual
        }
    }


    protected function generatePdf()
    {
        /* $identifyNeed = IdentifyNeed::find($identify_need_id); */
        // $establishment = $this->organizationalUnit->establishment;

        return Pdf::loadView('filament.clusters.talent-management.resources.identify-need-resource.documents.pdf_template', [
            'identifyNeed'  => $this,
            'user'          => User::find($this->user->id),
            'establishment' => $this->organizationalUnit->establishment,
        ])->stream('download.pdf');
    }

    public function sendForm()
    {
        if(Authority::getAmIAuthorityOfMyOu(now(), 'manager', $this->user_id) === true){
            dd('soy jefe');
        }
        else{
            //NO SOY JEFATURA, POR LO TANTO JEFATURA DE U.O. DEBE APROBAR
            $lastApproval = null;
            $count = 1;

            foreach($this->organizationalUnit->getHierarchicalUnits($this->user) as $hierarchicalUnit){
                if($lastApproval == null){
                    $pdfContent = $this->generatePdf(); // Método que genera el contenido del PDF
                    $name = Str::random(40);
                    $path = "ionline/identify_needs/sin_firmar/" . $name . ".pdf";
                    // Almacenar en GCS con un hashName
                    Storage::disk('gcs')->put($path, $pdfContent);
                }

                // Aquí usamos $path directamente para guardar la ruta relativa
                $filename = $path;

                // Valores para ubicar firma en dcto.
                if($count == 2){
                    $start = 82;
                }
                if($count == 3){
                    $start = 46;
                }
                if($count == 4){
                    $start = 10;
                }
                if($count == 5){
                    $start = -26;
                }

                $approval = $this->approvals()->create([
                    "module"                            => "Detección de Necesidades de Capacitación",
                    "module_icon"                       => "bi bi-person-video",
                    "subject"                           => 'DNC: ID '.$this->id.'<br>
                                                            Funcionario: '.$this->user->TinyName,
                    "sent_to_ou_id"                     =>  $hierarchicalUnit['id'],
                    "document_pdf_path"                 => ($lastApproval == null) ? $filename : $lastApproval->filename,
                    "active"                            => ($lastApproval == null) ? true : false,
                    "previous_approval_id"              => ($lastApproval == null) ? null : $lastApproval->id,
                    "status"                            =>  null,
                    "callback_controller_method"        => "App\Http\Controllers\IdentifyNeeds\IdentifyNeedController@approvalCallback",
                    "callback_controller_params"        => json_encode([
                        'identify_need_id'  => $this->id
                    ]),
                    "digital_signature"                 => true,
                    "position"                          => ($lastApproval == null) ? "center" : "right",
                    "start_y"                           => ($lastApproval == null) ? 82 : $start, //FALTA LA UBICACIÓN DE LA FIRMA PARA CADA CASO
                    "filename"                          => 'ionline/identify_needs/firmados/' . $name . '_'. $count .'.pdf',
                ]);
                $lastApproval = $approval;
                $count++;
            }
        }

        // Cambiar estado del registro
        $this->update(['status' => 'pending']);
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'dnc_identify_needs';
}
