<?php

namespace App\Models\Finance;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'fin_treasuries';

    protected $fillable = [
        'name',
        'bank_receipt_date',
        // 'bank_receipt_file',
        'third_parties_date',
        // 'third_parties_file',
        'treasureable_type',
        'treasureable_id',
        'user_id',
    ];

    public function treasureable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): HasOne
    {
        return $this->HasOne(User::class);
    }

    /**
     * Get third Parties file.
     */
    public function thirdPartiesFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'third_parties_file');
    }
 
    /**
     * Get bank receipt file.
     */
    public function bankReceiptFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'bank_receipt_file');
    }
}
