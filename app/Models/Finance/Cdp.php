<?php

namespace App\Models\Finance;

use App\Models\Documents\Approval;
use App\Models\Documents\Numeration;
use App\Models\Establishment;
use App\Models\Parameters\Parameter;
use App\Models\RequestForms\RequestForm;
use App\Models\User;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Cdp extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'file_path',
        'request_form_id',
        'user_id',
        'organizational_unit_id',
        'establishment_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $table = 'fin_cdps';

    public function requestForm(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class);
    }

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

    /**
     * Get the approval model.
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    /**
     * Get the numeration of the model.
     */
    public function numeration(): MorphOne
    {
        return $this->morphOne(Numeration::class, 'numerable');
    }

    public static function createCdp(RequestForm $requestForm): void 
    {
        $cdp = Cdp::create([
            'date' => $requestForm->created_at,
            'file_path' => $requestForm->file_path,
            'request_form_id' => $requestForm->id,
            'user_id' => null,
            'organizational_unit_id' => Parameter::get('Finanzas','ou_id', auth()->user()->establishment_id),
            'establishment_id' => auth()->user()->establishment_id,
        ]);

        $cdp->approval()->create([
            "module" => "CDP",
            "module_icon" => "fas fa-file-invoice-dollar",
            "subject" => "Certificado de Disponibilidad Presupuestaria",
            "document_route_name" => "finance.cdp.show",
            "document_route_params" => json_encode([
                "cdp" => $cdp->id
            ]),
            "sent_to_ou_id" => Parameter::get('Finanzas','ou_id'),
            "callback_controller_method" => "App\Http\Controllers\Finance\CdpController@approvalCallback",
            "callback_controller_params" => json_encode(['']),
            "digital_signature" => true,
            "position" => "right",
            "filename" => "ionline/finance/cdp/".time().str()->random(30).".pdf",
        ]);
    }
}
