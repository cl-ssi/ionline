<?php

namespace App\Models\Documents\Agreements;

use App\Enums\Documents\Agreements\Status;
use App\Models\ClCommune;
use App\Models\Documents\Approval;
use App\Models\Documents\Document;
use App\Models\Parameters\ApprovalFlow;
use App\Models\Parameters\Mayor;
use App\Models\Parameters\Municipality;
use App\Models\Parameters\Program;
use App\Observers\Documents\Agreements\ProcessObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ProcessObserver::class])]
class Process extends Model
{
    use SoftDeletes;

    protected $table = 'agr_processes';

    protected $fillable = [
        'program_id',
        'period',
        'process_type_id',
        'commune_id',
        'total_amount',
        'number',
        'date',
        'establishments',
        'quotas',
        'signer_id',
        'signer_appellative',
        'signer_decree',
        'signer_name',
        'municipality_id',
        'municipality_name',
        'municipality_rut',
        'municipality_adress',
        'mayor_id',
        'mayor_name',
        'mayor_run',
        'mayor_appelative',
        'mayor_decree',
        'status',
        'document_id',
        'next_process_id',
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

    public function processType(): BelongsTo
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

    public function nextProcess(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'next_process_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class, 'process_id');
    }

    /**
     * Get all of the approvations of a model.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function createOrUpdateDocument(): void
    {
        $documentData = [
            'type_id'                => 6,
            'subject'                => $this->program->name.' - '.$this->period.' - '.$this->commune->name,
            'content'                => $this->processType->template->parseTemplate($this),
            'user_id'                => auth()->id(),
            'organizational_unit_id' => auth()->user()->organizational_unit_id,
            'establishment_id'       => auth()->user()->establishment_id,
            'greater_hierarchy'      => 'from',
        ];

        if ($this->document_id) {
            $this->document->update($documentData);
        } else {
            $this->document()->associate(Document::create($documentData));
            $this->save();
        }
    }

    public function createApprovals($referer_id): void
    {
        // Referente
        $this->approvals()->create([
            "module" => "Convenios",
            "module_icon" => "fas fa-document",
            "subject" => "Visar convenio",
            "document_route_name" => "documents.show",
            "document_route_params" => json_encode([
                "document_id" => $this->document_id
            ]),
            "sent_to_user_id" => $referer_id,
        ]);

        // Flujos de aprobación
        $steps = ApprovalFlow::getByObject($this);
        foreach($steps as $step) {
            $this->approvals()->create([
                "module" => "Convenios",
                "module_icon" => "fas fa-document",
                "subject" => "Visar convenio",
                "document_route_name" => "documents.show",
                "document_route_params" => json_encode([
                    "document_id" => $this->document_id
                ]),
                "sent_to_ou_id" => $step->organizational_unit_id,
            ]);
        }
    }
}
