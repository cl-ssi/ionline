<?php

namespace App\Models\Cfg;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cfg_programs';

    protected $fillable = [
        'name',
        'start',
        'end',
    ];

    protected $dates = [
        'start',
        'end'
    ];

    public function getStartFormatAttribute()
    {
        $date = '-';
        if($this->start)
            $this->start->format('d/m/Y');
        return $date;
    }

    public function getEndFormatAttribute()
    {
        $date = '-';
        if($this->end)
            $this->end->format('d/m/Y');
        return $date;
    }
}
