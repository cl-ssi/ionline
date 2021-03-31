<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','bank_id','number','type'];

    // public function bank() {
    //     return $this->hasOne('\App\Models\Parameters\Bank','bank_id');
    // }

    public function bank() {
        return $this->belongsTo('\App\Models\Parameters\Bank','bank_id');
    }

}
