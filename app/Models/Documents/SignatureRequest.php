<?php

namespace App\Models\Documents;

use App\Enums\Documents\SignatureRequest\EndorseType;
use App\Enums\Documents\SignatureRequest\Status;
use App\Models\Documents\Approval;
use App\Models\Documents\Type;
use App\Models\Establishment;
use App\Models\File;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Observers\Documents\SignatureRequestObserver;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use PhpParser\Node\Stmt\StaticVar;

//Observed by
#[ObservedBy([SignatureRequestObserver::class])]
class SignatureRequest extends Model
{
    use HasFactory;

    protected $table = 'sign_signature_requests';

    protected $fillable = [
        'request_date',
        'original_file_path',
        'original_file_name',
        'url',
        'status',
        'user_id',
        'organizational_unit_id',
        'establishment_id',
        'type_id',
        'subject',
        'description',
        'recipients',
        'distribution',
        'reserved',
        'oficial',
        'sensitive',
        'signature_page_lastpage',
        'signature_page_number',
        'response_within_days',
        'endorse_type',
        'verification_code',
        'last_approval_id',
    ];

    protected $casts = [
        'status'    => Status::class,
        'reserved'  => 'boolean',
        'oficial'   => 'boolean',
        'sensitive' => 'boolean',
        'signature_page_lastpage' => 'boolean',
        'endorse_type' => EndorseType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function lastApproval(): BelongsTo
    {
        return $this->belongsTo(Approval::class, 'last_approval_id');
    }

    /**
     *  Approvals especificos para visaciones
     */
    public function visations(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->where('endorse', true);
    }

    /**
     *  Approvals especificos para firmas
     */
    public function signatures(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->where('endorse', false);
    }

    /**
     * Todos los approvals (visaciones y firmas)
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    /**
     * Para los anexos
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Esto muestra el tooltip sobre las visaciones
     * TODO: poder mostrar más texto, ej: Nombre completo, observación de rechazo, etc.
     */
    public function tooltip(): string
    {
        return collect($this->visations)
            ->pluck('initials')
            ->join(', ');
    }

}
