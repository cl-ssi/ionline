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
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable')->where('endorse',false);
    }

    public function endorses(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->where('endorse',operator: true);
    }

    public function createEndorses($referer_id): void
    {
        // no hacer nada si ya tiene visadores
        if ($this->endorses->isNotEmpty()) {
            return;
        }

        // Visación del Referente
        $this->endorses()->create([
            "module" => "Convenios",
            "module_icon" => "bi bi-file-earmark-text",
            "subject" => "Visar convenio",
            "document_route_name" => "documents.agreements.processes.view",
            "document_route_params" => json_encode([
                "record" => $this->id
            ]),
            "sent_to_user_id" => $referer_id,

            /* Aprobado por defecto */
            "approver_ou_id" => User::find($referer_id)->organizational_unit_id ?? null,
            "approver_id" => $referer_id,
            "approver_at" => now(),
            "status" => true,
        ]);

        // El resto de los visadores de obtienen del Flujo de aprobación
        $steps = ApprovalFlow::getByObject($this);
        foreach($steps as $step) {
            $this->endorses()->create([
                "module" => "Convenios",
                "module_icon" => "bi bi-file-earmark-text",
                "subject" => "Visar convenio",
                "document_route_name" => "documents.agreements.processes.view",
                "document_route_params" => json_encode([
                    "record" => $this->id
                ]),
                "endorse" => true,
                "sent_to_ou_id" => $step->organizational_unit_id,
            ]);
        }

    }
}
