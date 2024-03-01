<?php

namespace App\Models\Trainings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TrainingCost extends Model implements Auditable
{ 
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'type',
        'other_type',
        'exist', 
        'expense',
        'training_id'
    ];

    protected $table = 'tng_training_costs';
}
