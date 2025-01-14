<?php

namespace App\Models\Documents\Agreements;

use App\Models\Commune;
use App\Models\Documents\Approval;
use App\Models\Establishment;
use App\Models\Parameters\ApprovalFlow;
use App\Models\Parameters\Program;
use App\Models\User;
use App\Observers\Documents\Agreements\CertificateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        'date' => 'date',
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
        return $this->morphMany(Approval::class, 'approvable')->where('endorse',operator: true);
    }

    public function createApprovals($referer_id): void
    {
        // no hacer nada si ya tiene visadores
        if ($this->endorses->isNotEmpty()) {
            return;
        }

        // Visación del Referente
        $this->approvals()->create([
            "module" => "Convenios",
            "module_icon" => "bi bi-file-earmark-text",
            "subject" => "Visar Certificado",
            "document_route_name" => "documents.agreements.certificates.view",
            "document_route_params" => json_encode([
                "record" => $this->id
            ]),
            "sent_to_user_id" => $referer_id,

            /* Aprobado por defecto */
            "approver_ou_id" => User::find($referer_id)->organizational_unit_id ?? null,
            "approver_id" => $referer_id,
            "approver_at" => now(),
            "endorse" => true,
            "status" => true,
        ]);


        // Solo obtengo el último paso para mandar a firmar
        // En caso que a futuro sea una cadena de visación, se debe modificar
        $steps = ApprovalFlow::getByObject($this);
        $lastStep = $steps->last();

        $this->approvals()->create([
            "module" => "Convenios",
            "module_icon" => "bi bi-file-earmark-text",
            "subject" => "Firmar Certificado",
            "document_route_name" => "documents.agreements.certificates.view",
            "document_route_params" => json_encode([
                "record" => $this->id
            ]),
            "sent_to_ou_id" => $lastStep->organizational_unit_id,
            "digital_signature" => true,
            "position" => 'left',
            "start_y" => 80,
        ]);
    }
}
