<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Welfare\Benefits\Request;
use App\Models\User;

class Transfer extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_bnf_transfers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'request_id', 'installment_number', 'payed_date','payed_responsable_id','payed_amount'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    protected $casts = [
        'payed_date' => 'date:Y-m-d'
    ];

    // relations
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class,'payed_responsable_id');
    }
}
