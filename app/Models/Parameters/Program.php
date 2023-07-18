<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parameters\Subtitle;
use App\Models\Parameters\ProgramBudget;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cfg_programs';

    protected $fillable = [
        'name',
        'alias',
        'alias_finance',
        'financial_type',
        'folio',
        'subtitle_id',
        'budget',
        'period',
        'start_date',
        'end_date',
        'description',
        'is_program',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function Subtitle()
    {
        return $this->belongsTo(Subtitle::class);
    }

    public function Budgets()
    {
        return $this->hasMany(ProgramBudget::class);
    }

    public function getStartDateFormatAttribute()
    {
        $date = '-';
        if($this->start_date)
            $date = $this->start_date->format('Y-m-d');
        return $date;
    }

    public function getEndDateFormatAttribute()
    {
        $date = '-';
        if($this->end_date != null)
            $date = $this->end_date->format('Y-m-d');
        return $date;
    }

    public function getFinancingAttribute()
    {
        return strtolower($this->financial_type) != 'extrapresupuestario' ? 'Presupuestario' : 'Extrapresupuestario';
    }

    public function scopeOnlyValid($query)
    {
        return $query->whereIn('period', [now()->year, now()->year - 1]);
    }
}
