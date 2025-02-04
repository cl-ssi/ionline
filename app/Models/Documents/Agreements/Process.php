<?php

namespace App\Models\Documents\Agreements;

use App\Enums\Documents\Agreements\Status;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use App\Models\ClCommune;
use App\Models\Comment;
use App\Models\Documents\Approval;
use App\Models\Documents\Document;
use App\Models\Establishment;
use App\Models\File;
use App\Models\Parameters\ApprovalFlow;
use App\Models\Parameters\Mayor;
use App\Models\Parameters\Municipality;
use App\Models\Parameters\Program;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Observers\Documents\Agreements\ProcessObserver;
use Filament\Notifications;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

#[ObservedBy([ProcessObserver::class])]
class Process extends Model
{
    use SoftDeletes;

    protected $table = 'agr_processes';

    protected $fillable = [
        'process_type_id',
        'period',
        'program_id',
        'commune_id',
        'municipality_id',
        'municipality_name',
        'municipality_rut',
        'municipality_address',
        'mayor_id',
        'mayor_name',
        'mayor_run',
        'mayor_appellative',
        'mayor_decree',

        'total_amount',
        'quotas_qty',
        'establishments',

        'signer_id',
        'signer_appellative',
        'signer_decree',
        'signer_name',

        'number',
        'date',
        'status',

        'document_date',
        'document_content',
        'previous_process_id',

        'sended_revision_lawyer_at',
        'sended_revision_lawyer_user_id',
        'revision_by_lawyer_at',
        'revision_by_lawyer_user_id',

        'sended_revision_commune_at',
        'sended_revision_commune_user_id',
        'revision_by_commune_at',
        'revision_by_commune_user_id',

        'sended_endorses_at',
    
        'sended_to_commune_at',
        'returned_from_commune_at',

        'resolution_id',

        'establishment_id',
    ];

    protected $casts = [
        'document_date'            => 'date',
        'revision_by_lawyer_at'    => 'date',
        'revision_by_commune_at'   => 'date',
        'sended_to_commune_at'     => 'date',
        'returned_from_commune_at' => 'date',
        'date'                     => 'date',
        'sended_revision_lawyer_at' => 'date',
        'sended_revision_commune_at' => 'date',
        'sended_endorses_at'        => 'date',
        'establishments'           => 'array',
        'status'                   => Status::class,
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function processType(): BelongsTo|Builder
    {
        return $this->belongsTo(ProcessType::class, 'process_type_id');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class, 'commune_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class, 'signer_id');
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function mayor(): BelongsTo
    {
        return $this->belongsTo(Mayor::class, 'mayor_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function lawyerRevisionSenderUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'sended_revision_lawyer_user_id')->withTrashed();
    }

    public function revisionByLawyerUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'revision_by_lawyer_user_id')->withTrashed();
    }

    public function communeRevisionSenderUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'sended_revision_commune_user_id')->withTrashed();
    }

    public function revisionByCommuneUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'revision_by_commune_user_id')->withTrashed();
    }

    public function previousProcess(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'previous_process_id');
    }

    public function nextProcesses(): HasMany
    {
        return $this->hasMany(Process::class, 'previous_process_id', 'id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function quotas(): HasMany
    {
        return $this->hasMany(Quota::class, 'process_id');
    }

    protected function quotasCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quotas_qty ?? $this->quotas()->count(),
        );
    }

    // public function monthsArray(): Attribute 
    // {
    //     return Attribute::make(
    //         get: fn () => array_slice([
    //             'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    //             'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    //         ], 0, $this->quotasCount)
    //     );
    // }

    public function monthsArray(): Attribute 
{
    return Attribute::make(
        get: fn () => collect(
            array_slice([
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ], 0, $this->quotasCount)
        )->map(fn ($month) => (object)[
            'month' => $month,
            'amount' => number_format($this->quotasDivision, 2, ',', '.')
        ])
    );
}

    protected function quotasDivision(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quotas_qty ? $this->total_amount / $this->quotasCount : null,
        );
    }

    /**
     * Get all of the comments of a model.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get all of the approvations of a model.
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable')->where('endorse', false);
    }

    public function endorses(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->where('endorse', operator: true);
    }

    /**
     * Get the file model.
     */
    public function signedCommuneFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'signed_commune_file');
    }

    /**
     * Get the file model.
     */
    public function finalProcessFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'final_process_file');
    }

    public function resolution(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'resolution_id');
    }

    /**
     * Get all of the files of a model.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->whereNull('type');
    }

    // @sickiqq Parq que es esto?
    // Le falta el tipo de retorno
    // no existen esas foreign key en el modelo
    public function sentToOu()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'sent_to_ou_id');
    }

    public function sentToUser()
    {
        return $this->belongsTo(User::class, 'sent_to_user_id');
    }

    public function createOrUpdateDocument(): void
    {
        $this->document_content = $this->processType->template->parseTemplate($this);
        $this->save();
    }

    // Esto no se ocupa
    public function createNextProcess($process_type_id, $period, $program_id): int
    {
        $nextProcess = $this->nextProcesses()->create([
            'process_type_id' => $process_type_id,
            'period'          => $period,
            'program_id'      => $program_id,
            'commune_id'      => $this->commune_id,
            'municipality_id' => $this->municipality_id,
            'mayor_id'        => $this->mayor_id,
            'total_amount'    => $this->total_amount,
            'quotas_qty'      => $this->quotas_qty,
            'establishments'  => $this->establishments,
            'signer_id'       => $this->signer_id,
            // 'quotas'          => $this->quotas,
        ]);

        return $nextProcess->id;
    }

    /**
     * Crea las visaciones, depende del flujo de aprobación
     *
     * @param  mixed  $referer_id
     */
    public function createEndorses($referer_id): void
    {
        // no hacer nada si ya tiene visadores
        if ($this->endorses->isNotEmpty()) {
            return;
        }

        // Visación del Referente
        $this->endorses()->create([
            'module'                => 'Convenios',
            'module_icon'           => 'bi bi-file-earmark-text',
            'subject'               => 'Visar convenio',
            'document_route_name'   => 'documents.agreements.processes.view',
            'document_route_params' => json_encode([
                'record' => $this->id,
            ]),
            'sent_to_user_id' => $referer_id,
            'endorse'         => true,

            /* Aprobado por defecto */
            'approver_ou_id' => User::find($referer_id)->organizational_unit_id ?? null,
            'approver_id'    => $referer_id,
            'approver_at'    => now(),
            'status'         => true,
        ]);

        // Visación de juridico, esta vez no es a una unidad sino que a un usuario que tenga el permiso Agreement: legally
        $recipients = User::permission('Agreement: legally')->get();
        foreach ($recipients as $recipient) {
            $endorseData = [
                'module'                => 'Convenios',
                'module_icon'           => 'bi bi-file-earmark-text',
                'subject'               => 'Visar convenio',
                'document_route_name'   => 'documents.agreements.processes.view',
                'document_route_params' => json_encode([
                    'record' => $this->id,
                ]),
                'sent_to_user_id'     => $recipient->id,
                'endorse'             => true,
                'approvable_callback' => true,
            ];

            if ($this->processType->is_resolution) {
                $endorseData = array_merge($endorseData, [
                    'approver_ou_id' => $recipient->organizational_unit_id,
                    'approver_id'    => $recipient->id,
                    'approver_at'    => $this->revision_by_lawyer_at,
                    'status'         => true,
                ]);
            }

            $this->endorses()->create($endorseData);
        }

        // El resto de los visadores de obtienen del Flujo de aprobación
        $steps = ApprovalFlow::getByObject($this, $this->processType->is_resolution ? 'resolution' : 'other');
        foreach ($steps as $step) {
            $this->endorses()->create([
                'module'                => 'Convenios',
                'module_icon'           => 'bi bi-file-earmark-text',
                'subject'               => 'Visar convenio',
                'document_route_name'   => 'documents.agreements.processes.view',
                'document_route_params' => json_encode([
                    'record' => $this->id,
                ]),
                'endorse'             => true,
                'sent_to_ou_id'       => $step->organizational_unit_id,
                'approvable_callback' => true,
            ]);
        }
    }

    public function addNewEndorse($data): void
    {
        $this->endorses()->create([
            'module'                => 'Convenios',
            'module_icon'           => 'bi bi-file-earmark-text',
            'subject'               => 'Visar convenio',
            'document_route_name'   => 'documents.agreements.processes.view',
            'document_route_params' => json_encode([
                'record' => $this->id,
            ]),
            'endorse'             => true,
            'sent_to_user_id'     => $data['sent_to_user_id'],
            'sent_to_ou_id'       => $data['sent_to_ou_id'],
            'approvable_callback' => true,
        ]);
    }

    public function resetEndorsesStatus(): void
    {
        foreach ($this->endorses as $endorse) {
            $endorse->resetStatus();
        }
    }

    public function resetLegallyStatus(): void
    {
        $this->revision_by_lawyer_at      = null;
        $this->revision_by_lawyer_user_id = null;
        $this->save();
    }

    public function createApproval(): void
    {
        $approvalData = [
            'module'              => 'Convenios',
            'module_icon'         => 'bi bi-file-earmark-text',
            'subject'             => $this->processType->name,
            'sent_to_user_id'     => $this->signer->user->id,
            'digital_signature'   => true,
            'position'            => 'right',
            'filename'            => 'ionline/agreements/processes/'.Str::random(30).'.pdf',
            'approvable_callback' => true,
        ];

        // Si el tipo de proceso es resolución, la firma se hace utilizando la vista y parametro de la vista
        if ($this->processType->is_resolution) {
            $approvalData['start_y']               = 110;
            $approvalData['document_route_name']   = 'documents.agreements.processes.view';
            $approvalData['document_route_params'] = json_encode([
                'record' => $this->id,
            ]);
        }
        // Si el tipo de proceso es otro, entonces se utiliza el archivo almacenado el signedCommuneFile
        else {
            // Si no existe el archivo subido, no se crea la aprobación
            // TODO: Pendiente notificar al usuario que pasó esto
            if (! $this->signedCommuneFile) {
                return;
            }
            $approvalData['start_y']           = 35;
            $approvalData['document_pdf_path'] = $this->signedCommuneFile->filename;
        }

        if ($this->approval()->exists()) {
            $this->approval()->update($approvalData);
        } else {
            $this->approval()->create($approvalData);
        }
    }

    public function createComment($comment): void
    {
        $this->comments()->create([
            'body' => $comment,
        ]);
    }

    // attribute to convert amount to Number::spell($this->total_amount,locale:'es')
    public function totalAmountInWords(): Attribute
    {
        return Attribute::make(
            get: fn (): string => Number::spell($this->total_amount, locale: 'es')
        );
    }

    public function nextPeriod(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->period + 1
        );
    }

    public function documentDateFormat(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->formatDateSafely($this->document_date)
        );
    }

    public function dateFormat(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->formatDateSafely($this->date)
        );
    }

    public function totalAmountFormat(): Attribute
    {
        return Attribute::make(
            get: fn (): string => number_format($this->total_amount, 0, '', '.')
        );
    }

    // Attibute con los dias transcurridos desde $this->program->resource_distribution_date
    public function daysElapsed(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->program?->resource_distribution_date 
            ? round($this->program->resource_distribution_date->diffInDays()) 
            : null
        );
    }

    public function establishmentsList(): Attribute
    {
        $establishments = Establishment::whereIn('id', $this->establishments)->pluck('official_name')->toArray();

        // Muestrame todos lo establecimientos separados por coma
        return Attribute::make(
            get: fn (): string => implode(', ', $establishments)
        );
    }

    public function approvalCallback(): void
    {
        // Initialize variables with default values
        $allEndorsesApproved = false;
        $directorApproved    = false;

        // Primero ver si todos los endorses están aprobados
        if ($this->endorses->where('status', false)->isEmpty()) {
            $allEndorsesApproved = true;
        }

        // Ver si la firma de la directora está aprobada
        if ($this->approval?->status === true) {
            $directorApproved = true;
        }

        // Si todos los endorses están aprobados y la firma de la directora no
        if ($allEndorsesApproved && ! $directorApproved) {
            Notification::make()
                ->title('El proceso fue visado por todos')
                ->actions([
                    Notifications\Actions\Action::make('IrAlProceso')
                        ->button()
                        ->url(ProcessResource::getUrl('edit', [$this->id]))
                        ->markAsRead(),
                ])
                ->sendToDatabase($this->program->referers);

            // Notificar a los admin del modulo
            $recipients = User::permission('Agreement: admin')
                ->where('establishment_id', $this->establishment_id)
                ->get();
            Notification::make()
                ->title('El proceso fue visado por todos')
                ->actions([
                    Notifications\Actions\Action::make('IrAlProceso')
                        ->button()
                        ->url(ProcessResource::getUrl('edit', [$this->id]))
                        ->markAsRead(),
                ])
                ->sendToDatabase($recipients);
        }

        // Si todos los endorses están aprobados y la firma de la directora también
        if ($allEndorsesApproved && $directorApproved) {
            $this->update(['status' => 'finished']);

            // Notificar a los referentes
            Notification::make()
                ->title('Proceso firmado por el Director/a')
                ->actions([
                    Notifications\Actions\Action::make('IrAlProceso')
                        ->button()
                        ->url(ProcessResource::getUrl('edit', [$this->id]))
                        ->markAsRead(),
                ])
                ->sendToDatabase($this->program->referers);

            // Notificar a los admin del modulo
            $recipients = User::permission('Agreement: admin')
                ->where('establishment_id', $this->establishment_id)
                ->get();
            Notification::make()
                ->title('Proceso firmado por el Director/a')
                ->actions([
                    Notifications\Actions\Action::make('IrAlProceso')
                        ->button()
                        ->url(ProcessResource::getUrl('edit', [$this->id]))
                        ->markAsRead(),
                ])
                ->sendToDatabase($recipients);
        }

    }

    public function createOrUpdateAttachmentsToApprovals(): void
    {
        /**
         * Listado de adjuntos que debería tener cada aprobacion
         * - Resolucion que aprueba el programa
         * - Resolucion que distribuye los recursos
         * - Todos los certificados que tenga el programa
         */
        $files = [];

        if ($this->program->ministerial_resolution_file) {
            $files['Resolución aprobatoria'] = $this->program->ministerial_resolution_file;
        }
        if ($this->program->resource_distribution_file) {
            $files['Ditribución de recursos'] = $this->program->resource_distribution_file;
        }

        foreach ($this->program->certificates as $certificate) {
            if ($certificate->signer and $certificate->signer->status === true) {
                $files[$certificate->processType->name] = $certificate->signer->filename;
            }
        }

        // Crear o actualizar los adjuntos para cada endorses
        foreach ($this->endorses as $endorse) {
            foreach ($files as $name => $storage_path) {
                $endorse->attachments()->updateOrCreate(
                    ['name' => $name],
                    [
                        'storage_path' => $storage_path,
                        'stored'       => true,
                    ]
                );
            }
        }

        // Crear o actualizar los adjuntos para el firmante (approval)
        foreach ($files as $name => $storage_path) {
            $this->approval?->attachments()->updateOrCreate(
                ['name' => $name],
                [
                    'storage_path' => $storage_path,
                    'stored'       => true,
                ]
            );
        }
    }

    protected function formatDateSafely($date): string
    {
        return $date
            ? "{$date->day} de {$date->monthName} del {$date->year}"
            : 'XXX de XXX del XXX';
    }
}
