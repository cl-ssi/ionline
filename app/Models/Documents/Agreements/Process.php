<?php

namespace App\Models\Documents\Agreements;

use App\Enums\Documents\Agreements\Status;
use App\Models\ClCommune;
use App\Models\Comment;
use App\Models\Documents\Approval;
use App\Models\Documents\Document;
use App\Models\Establishment;
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
use Illuminate\Database\Eloquent\Relations\MorphOne;
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
        'quotas_qty',
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
        'document_content',
        'next_process_id',
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
        return $this->morphOne(Approval::class, 'approvable')->where('endorse',false);
    }
    public function endorses(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->where('endorse',operator: true);
    }

    public function createOrUpdateDocument(): void
    {
        $this->document_content = $this->processType->template->parseTemplate($this);
        $this->save();
        // $documentData = [
        //     'type_id'                => 6,
        //     'subject'                => $this->program->name.' - '.$this->period.' - '.$this->commune->name,
        //     'content'                => $this->processType->template->parseTemplate($this),
        //     'user_id'                => auth()->id(),
        //     'organizational_unit_id' => auth()->user()->organizational_unit_id,
        //     'establishment_id'       => auth()->user()->establishment_id,
        //     'greater_hierarchy'      => 'from',
        // ];

        // if ($this->document_id) {
        //     $this->document->update($documentData);
        // } else {
        //     $this->document()->associate(Document::create($documentData));
        //     $this->save();
        // }
    }

    public function createNextProcess(): void
    {
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
        // Visación del Referente
        $this->approvals()->create([
            "module" => "Convenios",
            "module_icon" => "fas fa-handshake",
            "subject" => "Visar convenio",
            "document_route_name" => "documents.agreements.processes.view",
            "document_route_params" => json_encode([
                "record" => $this->id
            ]),
            "sent_to_user_id" => $referer_id,
        ]);

        // El resto de los visadores de obtienen del Flujo de aprobación
        $steps = ApprovalFlow::getByObject($this);
        foreach($steps as $step) {
            $this->approvals()->create([
                "module" => "Convenios",
                "module_icon" => "fas fa-handshake",
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

    public function createApproval(): void
    {
        // Solicitud de firma del director
        $this->approval()->create([
            "module" => "Convenios",
            "module_icon" => "fas fa-handshake",
            "subject" => "Firmar convenio",
            "document_route_name" => "documents.agreements.processes.view",
            "document_route_params" => json_encode([
                "record" => $this->id
            ]),
            "digital_signature" => true,
            "sent_to_ou_id" => $this->signer->user->organizational_unit_id,
        ]);
    }
}
