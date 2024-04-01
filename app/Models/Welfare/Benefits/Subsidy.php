<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Welfare\Benefits\Benefit;
use App\Models\Welfare\Benefits\Document;
use App\Models\Welfare\Benefits\Request;

class Subsidy extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_bnf_subsidies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'benefit_id', 'name','description','annual_cap','payment_in_installments','recipient','status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    // protected $casts = [
    //     'fecha_inicio' => 'date:Y-m-d',
    //     'fecha_termino' => 'date:Y-m-d',
    //     'fecha_termino_2' => 'date:Y-m-d',
    // ];

    // relations
    public function benefit(): BelongsTo
    {
        return $this->belongsTo(Benefit::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function getSubsidyUsedMoney(){
        $requests = Request::whereYear('created_at',now()->format('Y'))
                            ->where('applicant_id', auth()->user()->id)
                            ->where('subsidy_id', $this->id)
                            ->where('status', 'Aceptado')
                            ->get();
        
        $accepted_amount = 0;
        foreach($requests as $request){
            $accepted_amount += $request->accepted_amount;
        }   

        return $accepted_amount;
    }
}
