<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
use App\Models\Parameters\Parameter;
use Illuminate\Support\Facades\Auth;
use App\Models\IdentifyNeeds\AvailablePlace;
use App\Models\IdentifyNeeds\AuthorizeAmount;

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
        'telephone',
        'mobile',

        // JEFATURA
        'boss_id',
        'boss_email',

        'subject',
        'total_hours',
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
        'accommodation_price',
        'activity_value',
        'total_value'
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
     * Get the available places for the identify need.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availablePlaces(): HasMany
    {
        return $this->hasMany(AvailablePlace::class, 'identify_need_id');
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
     * Get the authorize amount for the identify need.
     */
    public function authorizeAmount(): HasOne
    {
        return $this->hasOne(AuthorizeAmount::class);
    }

    /*
    public function approvalCallback(): void
    {
        $this->update(['status' => 'completed']);
    }
    */

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
            'completed' => 'Finalizado',
            'rejected'  => 'Rechazado',
        ];

        return $statuses[$this->status] ?? null;
    }

    /**
     * Get the family position value attribute.
     *
     * @return string|null
     */
    public function getFamilyPositionValueAttribute(): ?string
    {
        $familyPositions = [
            'profesional directivo'         => 'Profesional Directivo', 
            'profesional gestion'           => 'Profesional de Gestión',
            'profesional asistencial'       => 'Profesional Asistencial',
            'tecnico de apoyo a la gestion' => 'Técnico de Apoyo a la Gestión',
            'tecnico asistencial'           => 'Técnico Asistencial',
            'administrativo apoyo gestion'  => 'Administrativo(a) de Apoyo a la Gestión',
            'administrativo asistencial'    => 'Administrativo(a) Asistencial',
            'auxiliar apoyo operaciones'    => 'Auxiliar de Apoyo de Operaciones',
            'auxiliar conductor'            => 'Auxiliar Conductor',
        ];

        return $familyPositions[$this->family_position] ?? null;
    }

    /**
     * Get the training type value attribute.
     *
     * @return string|null
     */
    public function getTrainingTypeValueAttribute(): ?string
    {
        $trainingTypes = [
            'curso'                         => 'Curso', 
            'taller'                        => 'Taller',
            'jornada'                       => 'Jornada',
            'estadia pasantia'              => 'Estadía Pasantía',
            'perfeccionamiento diplomado'   => 'Perfeccionamiento Diplomado',
            'otro'                          => 'Otro',
        ];

        return $trainingTypes[$this->training_type] ?? null;
    }

    /**
     * Get the strategic axis value attribute.
     *
     * @return string|null
     */
    public function getStrategicAxisValueAttribute(): ?string
    {
        return $this->strategicAxis 
            ? ucfirst(strtolower($this->strategicAxis->name)) 
            : null;
    }

    /**
     * Get the impact objective value attribute.
     *
     * @return string|null
     */
    public function getImpactObjectiveValueAttribute(): ?string
    {
        return $this->impactObjective 
            ? ucfirst($this->impactObjective->description) 
            : null;
    }

    /**
     * Get the mechanism value attribute.
     *
     * @return string|null
     */
    public function getMechanismValueAttribute(): ?string
    {
        $mechanisms = [
            'online'        => 'Online',
            'presencial'    => 'Presencial',
            'semipresencial'=> 'Semipresencial',
        ];

        return $mechanisms[$this->mechanism] ?? null;
    }

    /**
     * Get the online type mechanism value attribute.
     *
     * @return string|null
     */
    public function getOnlineTypeMechanismValueAttribute(): ?string
    {
        $mechanisms = [
            'sincronico'    => 'Sincrónico',
            'asincronico'   => 'Asincrónico',
            'mixta'         => 'Mixta',
        ];

        return $mechanisms[$this->online_type_mechanism] ?? null;
    }

    /**
     * Get the formatted value for the `exists` boolean attribute.
     */
    public function getExistsValueAttribute(): string
    {
        return $this->exists !== null
            ? ($this->exists ? 'Sí' : 'No')
            : '';
    }

    /**
     * Get the formatted value for the `digital_capsule` boolean attribute.
     */
    public function getDigitalCapsuleValueAttribute(): string
    {
        return $this->digital_capsule !== null
            ? ($this->digital_capsule ? 'Sí' : 'No')
            : '';
    }

    /**
     * Get the formatted value for the `coffee_break` boolean attribute.
     */
    public function getCoffeeBreakValueAttribute(): string
    {
        return $this->coffee_break !== null
            ? ($this->coffee_break ? 'Sí' : 'No')
            : '';
    }

    /**
     * Get the item value attribute.
     *
     * @return string|null
     */
    public function getNatureOfTheNeedValueAttribute(): ?string
    {
        $natureOfTheNeed = [
            'red asistencial'   => 'Red Asistencial',
            'dss'               => 'Dirección Servicio de Salud',
        ];

        return $natureOfTheNeed[$this->nature_of_the_need] ?? null;
    }

    /**
     * Define eventos del modelo.
     */

     /*
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
    */

    /*
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
    */

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
        $authority = Authority::getAuthorityFromDate($this->organizational_unit_id, now(), 'manager');
        /**
         *  Si soy autoridad de nivel 2, mandó directamente a dirección
         */ 
        if($authority->organizationalUnit->level == 2){
            $approval = $this->approvals()->create([
                "module"                            => "Detección de Necesidades de Capacitación",
                "module_icon"                       => "bi bi-person-video",
                "subject"                           => 'DNC: ID '.$this->id.'<br>
                                                        Funcionario: '.$this->user->TinyName,
                "sent_to_ou_id"                     =>  1,
                "document_route_name"               => "identify_need.show_approval",
                "document_route_params"             => json_encode([
                    "identify_need_id" => $this->id,
                ]),
                "active"                            => true,
                "previous_approval_id"              => null,
                "status"                            => null,
                "callback_controller_method"        => "App\Http\Controllers\IdentifyNeeds\IdentifyNeedController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'identify_need_id'  => $this->id,
                    'process'           => 'end'
                ])
            ]);
        }
        /**
         *  Si no mandó aprobaciones según orden jerarquíco
         */ 
        else{
            $lastApproval = null;
            $count = 1;

            $hierarchicalUnits = $this->organizationalUnit->getHierarchicalUnits($this->user);
            $lastUnit = end($hierarchicalUnits); // Obtiene el último elemento del arreglo

            foreach($this->organizationalUnit->getHierarchicalUnits($this->user) as $hierarchicalUnit){
                $isLastIteration = ($hierarchicalUnit === $lastUnit); // Verifica si es la última iteración
                $approval = $this->approvals()->create([
                    "module"                            => "Detección de Necesidades de Capacitación",
                    "module_icon"                       => "bi bi-person-video",
                    "subject"                           => 'DNC: ID '.$this->id.'<br>
                                                            Funcionario: '.$this->user->TinyName,
                    "sent_to_ou_id"                     =>  $hierarchicalUnit['id'],
                    "document_route_name"               => "identify_need.show_approval",
                    "document_route_params"             => json_encode([
                        "identify_need_id" => $this->id,
                    ]),
                    "active"                            => ($lastApproval == null) ? true : false,
                    "previous_approval_id"              => ($lastApproval == null) ? null : $lastApproval->id,
                    "status"                            => null,
                    "callback_controller_method"        => "App\Http\Controllers\IdentifyNeeds\IdentifyNeedController@approvalCallback",
                    "callback_controller_params"        => json_encode([
                        'identify_need_id'  => $this->id,
                        'process'           => ($isLastIteration) ? 'end' : null,
                    ])
                ]);
                $lastApproval = $approval;
                $count++;
            }
        }

        // Cambiar estado del registro
        $this->update(['status' => 'pending']);
    }

    public function sendFormForExternal()
    {   
        $approval = $this->approvals()->create([
            "module"                            => "Detección de Necesidades de Capacitación",
            "module_icon"                       => "bi bi-person-video",
            "subject"                           => 'DNC: ID '.$this->id.'<br>
                                                    Funcionario: '.$this->user->TinyName,
            "sent_to_ou_id"                     => Parameter::get('ou', 'DireccionAPS', Auth::user()->establishment_id),
            "document_route_name"               => "identify_need.show_approval",
            "document_route_params"             => json_encode([
                "identify_need_id" => $this->id,
            ]),
            "active"                            => true,
            "previous_approval_id"              => null,
            "status"                            => null,
            "callback_controller_method"        => "App\Http\Controllers\IdentifyNeeds\IdentifyNeedController@approvalCallback",
            "callback_controller_params"        => json_encode([
                'identify_need_id'  => $this->id,
                'process'           => 'end'
            ])
        ]);

        // Cambiar estado del registro
        $this->update(['status' => 'pending']);
    }

    public function createAuthorizeAmount()
    {
        if($this->authorizeAmount){
            return redirect()->route('filament.intranet.talent-management.resources.authorize-amounts.edit', [
                'record' => $this->authorizeAmount
            ]);
        }
        else{ 
            $authorizeAmount = $this->authorizeAmount()->create([
                'identify_need_id'  => $this->id,
                'status'            => 'pending', 
            ]);

            return redirect()->route('filament.intranet.talent-management.resources.authorize-amounts.edit', [
                'record' => $authorizeAmount->id
            ]);
        }
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'dnc_identify_needs';
}
