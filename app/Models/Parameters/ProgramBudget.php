<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Parameters\Program;
use App\Models\Establishment;

class ProgramBudget extends Model
{
    use HasFactory;

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'cfg_program_budgets';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'program_id',
        'ammount',        
        'observation',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */ 

    

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

}