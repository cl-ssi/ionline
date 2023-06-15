<?php

namespace App\Models\Summary;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Summary extends Model
{
    use SoftDeletes;

    protected $table = 'sum_summaries';
    protected $fillable = [
        'name', 
        'status',
        'establishment_id',
        'creator_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
