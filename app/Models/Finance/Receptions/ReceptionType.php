<?php

namespace App\Models\Finance\Receptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Finance\Receptions\Reception;

class ReceptionType extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'fin_reception_types';

    protected $fillable = [
        'id',
        'name',
        'title',
        'establishment_id',
    ];

    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }
    
}
