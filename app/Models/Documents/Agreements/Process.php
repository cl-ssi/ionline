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
use App\Models\User;
use App\Observers\Documents\Agreements\ProcessObserver;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'municipality_adress',
        'mayor_id',
        'mayor_name',
        'mayor_run',
        'mayor_appelative',
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

        // 'document_id',
        'document_content',
        'next_process_id',

        'revision_by_lawyer_at',
        'revision_by_lawyer_user_id',
        'revision_by_commune_at',
        'revision_by_commune_user_id',
        'sended_to_commune_at',
        'returned_from_commune_at',

        'establishment_id',
    ];

    protected $casts = [
        'date'           => 'date',
        'establishments' => 'array',
        'status'         => Status::class,
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

    public function revisionByLawyerUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'revision_by_lawyer_user_id')->withTrashed();
    }

    public function revisionByCommuneUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'revision_by_commune_user_id')->withTrashed();
    }

    public function nextProcess(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'next_process_id');
    }

    public function previousProcess(): HasOne
    {
        return $this->hasOne(Process::class, 'next_process_id', 'id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function quotas(): HasMany
    {
        return $this->hasMany(Quota::class, 'process_id');
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

    public function createOrUpdateDocument(): void
    {
        $this->document_content = $this->processType->template->parseTemplate($this);
        $this->save();
    }

    public function createNextProcess(): void
    {
        // tiene childProcessType?
        if (! $this->processType->childProcessType) {
            // Notificacion
            Notification::make()
                ->danger()
                ->title('El tipo de proceso, no tiene asignado un siguiente proceso, contacte al administrador del módulo');

            return;
        }
        $nextProcess = $this->nextProcess()->create([
            'process_type_id' => $this->processType->childProcessType->id,
            'period'          => $this->period,
            'program_id'      => $this->program_id,
            'commune_id'      => $this->commune_id,
            'municipality_id' => $this->municipality_id,
            'mayor_id'        => $this->mayor_id,
            'total_amount'    => $this->total_amount,
            'quotas_qty'      => $this->quotas_qty,
            'establishments'  => $this->establishments,
            'signer_id'       => $this->signer_id,
            // 'quotas'          => $this->quotas,
        ]);

        $this->update(['next_process_id' => $nextProcess->id]);
    }

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

            /* Aprobado por defecto */
            'approver_ou_id' => User::find($referer_id)->organizational_unit_id ?? null,
            'approver_id'    => $referer_id,
            'approver_at'    => now(),
            'status'         => true,
        ]);

        // El resto de los visadores de obtienen del Flujo de aprobación
        $steps = ApprovalFlow::getByObject($this);
        foreach ($steps as $step) {
            $this->endorses()->create([
                'module'                => 'Convenios',
                'module_icon'           => 'bi bi-file-earmark-text',
                'subject'               => 'Visar convenio',
                'document_route_name'   => 'documents.agreements.processes.view',
                'document_route_params' => json_encode([
                    'record' => $this->id,
                ]),
                'endorse'       => true,
                'sent_to_ou_id' => $step->organizational_unit_id,
            ]);
        }
    }

    public function resetEndorsesStatus(): void
    {
        foreach ($this->endorses as $endorse) {
            $endorse->resetStatus();
        }
    }

    public function createApproval(): void
    {
        // Solicitud de firma del director
        $this->approval()->create([
            'module'                => 'Convenios',
            'module_icon'           => 'bi bi-file-earmark-text',
            'subject'               => 'Firmar convenio',
            'document_route_name'   => 'documents.agreements.processes.view',
            'document_route_params' => json_encode([
                'record' => $this->id,
            ]),
            'sent_to_ou_id'       => $this->signer->user->organizational_unit_id,
            'digital_signature'   => true,
            'position'            => 'right',
            'start_y'             => 150,
            'filename'            => 'ionline/agreements/processes/'.Str::random(30).'.pdf',
            'approvable_callback' => true,
        ]);
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

    public function dateFormat(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->formatDateSafely($this->date)
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

    protected function formatDateSafely($date): string
    {
        return $date
            ? "{$date->day} de {$date->monthName} del {$date->year}"
            : 'XXX de XXX del XXX';
    }

    public function approvalCallback(): void
    {
        $this->update(['status' => 'finished']);

        // Notificar a los referentes
        Notification::make()
            ->title('Proceso Firmado por el Director')
            ->actions([
                Action::make('IrAlProceso')
                    ->button()
                    ->url(ProcessResource::getUrl('edit', [$this->id]))
                    ->markAsRead(),
            ])
            ->sendToDatabase($this->program->referers);

    }
}
