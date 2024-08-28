<?php

namespace App\Models\Finance;

use App\Models\Documents\Approval;
use App\Models\Documents\Numeration;
use App\Models\Establishment;
use App\Models\Parameters\Parameter;
use App\Models\RequestForms\RequestForm;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
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
}
