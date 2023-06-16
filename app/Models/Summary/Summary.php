<?php

namespace App\Models\Summary;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Models\Establishment;
use App\Models\Summary\SummaryEvent;

class Summary extends Model
{
    use SoftDeletes;

    protected $table = 'sum_summaries';
    protected $fillable = [
        'name', 
        'status',
        'start_date',
        'end_date',
        'observation',
        'investigator_id',
        'actuary_id',
        'establishment_id',
        'creator_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function summaryEvents()
    {
        return $this->hasMany(SummaryEvent::class, 'summary_id');
    }
}
