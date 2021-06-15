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

    public function user() {
        return $this->belongsTo('\App\User','user_id');
    }




    public function getTypeText() {
        switch($this->type) {
          case '01':
            return 'CTA CORRIENTE / CTA VISTA';
            break;
          case '02':
            return 'CTA AHORRO';
            break;
          case '30':
            return 'CUENTA RUT';
            break;
        }
    }


}
