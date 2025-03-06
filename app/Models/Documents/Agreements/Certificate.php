<?php

namespace App\Models\Documents\Agreements;

use Filament\Forms;
use App\Models\User;
use App\Models\Commune;
use Filament\Notifications;
use Illuminate\Support\Str;
use App\Models\Establishment;
use App\Models\Documents\Approval;
use App\Models\Parameters\Program;
use App\Models\Parameters\ApprovalFlow;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Documents\Agreements\Status;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Documents\Agreements\CertificateObserver;
use App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource;

#[ObservedBy([CertificateObserver::class])]
class Certificate extends Model
{
    protected $table = 'agr_certificates';

    protected $fillable = [
        'process_type_id',
        'period',
        'program_id',
        'commune_id',
        'number',
        'date',
        'status',
        'document_content',
        'establishment_id',
    ];

    protected $casts = [
        'date'   => 'date',
        'status' => Status::class,
    ];

    public function processType(): BelongsTo
    {
        return $this->belongsTo(ProcessType::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get all of the approvations of a model.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function endorses(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->where('endorse', operator: true);
    }

    public function signer(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable')->where('endorse', operator: false);
    }

    public function approvalCallback(): void
    {
        $this->update(['status' => 'finished']);

        foreach($this->program->processes as $process) {
            $process->createOrUpdateAttachmentsToApprovals();
        }

        $this->createOrUpdateAttachmentsToApprovals();

        // Notificar a los administradores 'Agreement: admin'
        Notifications\Notification::make()
            ->title('Nuevo certificado aprobado por Gestión Financiera')
            ->actions([
                Forms\Components\Actions\Action::make('IrAlProceso')
                    ->button()
                    ->url(CertificateResource::getUrl('edit', [$this->id]))
                    ->markAsRead(),
            ])
            ->sendToDatabase($this->program->referers);

    }

    public function createApprovals($referer_id): void
    {
        // no hacer nada si ya tiene visadores
        if ($this->endorses->isNotEmpty()) {
            return;
        }

        // Visación del Referente
        $this->approvals()->create([
            'module'                => 'Convenios',
            'module_icon'           => 'bi bi-file-earmark-text',
            'subject'               => 'Visar Certificado',
            'document_route_name'   => 'documents.agreements.certificates.view',
            'document_route_params' => json_encode([
                'record' => $this->id,
            ]),
            'sent_to_user_id' => $referer_id,

            /* Aprobado por defecto */
            'approver_ou_id' => User::find($referer_id)->organizational_unit_id ?? null,
            'approver_id'    => $referer_id,
            'approver_at'    => now(),
            'endorse'        => true,
            'status'         => true,
        ]);

        // Solo obtengo el último paso para mandar a firmar
        // En caso que a futuro sea una cadena de visación, se debe modificar
        $steps    = ApprovalFlow::getByObject($this);
        $lastStep = $steps->last();

        $this->approvals()->create([
            'module'                => 'Convenios',
            'module_icon'           => 'bi bi-file-earmark-text',
            'subject'               => 'Firmar Certificado',
            'document_route_name'   => 'documents.agreements.certificates.view',
            'document_route_params' => json_encode([
                'record' => $this->id,
            ]),
            'sent_to_ou_id'       => $lastStep->organizational_unit_id,
            'digital_signature'   => true,
            'position'            => 'right',
            'start_y'             => 60,
            'filename'            => 'ionline/agreements/certificates/'.Str::random(30).'.pdf',
            'approvable_callback' => true,
        ]);

        $this->createOrUpdateAttachmentsToApprovals();
    }

    public function createOrUpdateAttachmentsToApprovals(): void {
        /** 
         * Listado de adjuntos que debería tener cada aprobacion
         * - Resolucion que aprueba el programa
         * - Resolucion que distribuye los recursos
        */

        $files = [];

        if ($this->program->ministerial_resolution_file) {
            $files['Resolución aprobatoria'] = $this->program->ministerial_resolution_file;
        }
        if ($this->program->resource_distribution_file) {
            $files['Ditribución de recursos'] = $this->program->resource_distribution_file;
        }

        // Crear o actualizar los adjuntos para cada endorses
        foreach($this->approvals as $approval) {
            foreach($files as $name => $storage_path) {
                $approval->attachments()->updateOrCreate(
                    ['name' => $name],
                    [
                        'storage_path' => $storage_path,
                        'stored' => true,
                    ]
                );
            }
        }
    }

    public function sentToOu()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'sent_to_ou_id');
    }

    public function addNewEndorse($data): void
    {
        $this->endorses()->create([
            'module'                => 'Convenios',
            'module_icon'           => 'bi bi-file-earmark-text',
            'subject'               => 'Visar Certificado',
            'document_route_name'   => 'documents.agreements.certificates.view',
            'document_route_params' => json_encode([
                'record' => $this->id,
            ]),
            'endorse'             => true,
            'sent_to_user_id'     => $data['sent_to_user_id'],
            'sent_to_ou_id'       => $data['sent_to_ou_id'],
            'approvable_callback' => true,
        ]);
    }
}
