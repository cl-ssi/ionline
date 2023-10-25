<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parameters\Subtitle;
use App\Models\Parameters\ProgramBudget;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class Program extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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

    public static function getProgramsBySearch($searchText)
    {
        $programs = Program::query();
        $array_search = explode(' ', $searchText);
        foreach($array_search as $word){
            $programs->where(function($q) use($word){
                $q->where('name', 'LIKE', '%'.$word.'%');
                // ->where('period', Carbon::now()->year);
            });
        }

        return $programs->where('period', '>=', 2024);
    }
}
