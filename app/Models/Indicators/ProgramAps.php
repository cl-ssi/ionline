<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramAps extends Model
{
    use HasFactory;

    protected $table = 'ind_program_aps';
    protected $fillable = ['name', 'year'];

    public function tracers()
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }
}
