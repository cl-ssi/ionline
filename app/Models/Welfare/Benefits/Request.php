<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Welfare\Benefits\Request as RequestModel;
use App\Models\Welfare\Benefits\Subsidy;
// use App\Models\Welfare\Benefits\Transfer;
use App\Models\User;
use App\Models\File;

class Request extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_bnf_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'subsidy_id', 'applicant_id', 'requested_amount', 'status', 'installments_number', 'status_update_date', 'status_update_responsable_id', 'status_update_observation', 
        'accepted_amount_date','accepted_amount_responsable_id','accepted_amount','payed_date','payed_responsable_id','payed_amount','created_at','folio_number'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    protected $casts = [
        'status_update_user_id' => 'date:Y-m-d',
        'payed_date' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d'
    ];

    // relations
    public function subsidy(): BelongsTo
    {
        return $this->belongsTo(Subsidy::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'status_update_responsable_id');
    }

    // public function files(): HasMany
    // {
    //     return $this->hasMany(File::class,'well_bnf_request_id');
    // }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class,'applicant_id');
    }

    // public function transfers(): HasMany
    // {
    //     return $this->hasMany(Transfer::class);
    // }

    // sin considerar este request
    // se utiliza principalmente para actualizar sin problemas el accepted_amount de un request
    public function getSubsidyUsedMoney(){
        $requests = RequestModel::whereYear('created_at',$this->created_at->format('Y'))
                                ->where('applicant_id', $this->applicant_id)
                                ->where('subsidy_id', $this->subsidy_id)
                                ->where('status', 'Aceptado')
                                ->where('id','!=',$this->id)
                                ->get();
        
        $accepted_amount = 0;
        foreach($requests as $request){
            $accepted_amount += $request->accepted_amount;
        }   

        return $accepted_amount;
    }

    // considera todos los requests involucrados (sirve para la vista admin requests)
    public function getSubsidyUsedMoneyAll(){
        $requests = RequestModel::whereYear('created_at',$this->created_at->format('Y'))
                                ->where('applicant_id', $this->applicant_id)
                                ->where('subsidy_id', $this->subsidy_id)
                                ->where('status', 'Aceptado')
                                ->get();
        
        $accepted_amount = 0;
        foreach($requests as $request){
            $accepted_amount += $request->accepted_amount;
        }   

        return $accepted_amount;
    }
}
