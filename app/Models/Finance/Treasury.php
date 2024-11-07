<?php

namespace App\Models\Finance;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Treasury extends Model
{
    protected $table = 'fin_treasuries';

    protected $fillable = [
        'name',
        'description',
        'resolution_folio',
        'resolution_date',
        'resolution_file',
        'commitment_folio_sigfe',
        'commitment_date_sigfe',
        'commitment_file_sigfe',
        'accrual_folio_sigfe',
        'accrual_date_sigfe',
        'accrual_file_sigfe',
        'bank_receipt_date',
        'bank_receipt_file',
        'treasureable_type',
        'treasureable_id',
    ];

    public function treasureable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get support file, archivo de respaldo.
     */
    public function supportFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'support_file');
    }
}
