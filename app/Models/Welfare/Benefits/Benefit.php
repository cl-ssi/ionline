<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Welfare\Benefits\Subsidy;
use App\Models\Welfare\Benefits\Request;

class Benefit extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_bnf_benefits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'observation'
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

    public function subsidies(): HasMany
    {
        // 13/06/2024: se comenta por solicitud de bienestar
        // la siguiente validación permite saber y excluir los beneficios que hayan alcanzado su tope anual
        // $subsidies_array = [];
        // $subsidies = Subsidy::where('benefit_id',$this->id)->where('status',1)->get();
        // foreach($subsidies as $subsidy){
        //     $requests = Request::whereYear('created_at',now()->format('Y'))
        //                     ->where('applicant_id', auth()->user()->id)
        //                     ->where('subsidy_id', $subsidy->id)
        //                     ->where('status', 'Aceptado')
        //                     ->get();
            
        //     $accepted_amount = 0;
        //     foreach($requests as $request){
        //         $accepted_amount += $request->accepted_amount;
        //     }  

        //     if($subsidy->annual_cap != null && $accepted_amount == $subsidy->annual_cap){
                
        //     }else{
        //         array_push($subsidies_array, $subsidy->id);
        //     }
        // }

        // return $this->hasMany(Subsidy::class)->whereIn('id',$subsidies_array);

        return $this->hasMany(Subsidy::class);
    }
}
