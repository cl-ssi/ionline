<?php

namespace App\Models\Finance;

use App\Models\User;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Accountancy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'fin_accountancies';

    protected $fillable = [

        'resolution_folio',
        'resolution_date',
        'resolution_file',
        'commitment_folio_sigfe',
        'commitment_date_sigfe',
        'commitment_file_sigfe',
        'accrual_folio_sigfe',
        'accrual_date_sigfe',
        'accrual_file_sigfe',
        'accountable_type',
        'accountable_id',
        'user_id',
    ];

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): HasOne
    {
        return $this->HasOne(User::class);
    }

    
    /**
    * Get resolution file.
    */
    public function resolutionFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'resolution_file');
    }


    /**
    * Get bank receipt file.
    */
    public function commitmentSigfeFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'commitment_file_sigfe');
    }

    /**
    * Get bank receipt file.
    */
    public function accrualSigfeFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'accrual_file_sigfe');
    }


}

