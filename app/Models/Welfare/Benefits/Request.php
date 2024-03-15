<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Welfare\Benefits\Subsidy;
use App\Models\Welfare\Benefits\File;
use App\User;

class Request extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_bnf_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'subsidy_id', 'applicant_id', 'status', 'status_update_date', 'status_update_responsable_id', 'status_update_observation', 
        'created_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    protected $casts = [
        'status_update_user_id' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d'
    ];

    // relations
    public function subsidy(): BelongsTo
    {
        return $this->belongsTo(Subsidy::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class,'well_bnf_request_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class,'applicant_id');
    }
}
