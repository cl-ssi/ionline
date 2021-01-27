<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsiRequest extends Model
{
    use HasFactory;

    public $table = 'psi_requests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'start_date',
        'disability',
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
      }


}
