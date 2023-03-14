<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SirhActiveUser extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'dv', 'name', 'email', 'birthdate', 'start_contract_date', 'end_contract_date', 'legal_quality', 'ou_description'];

    protected $table = 'sirh_active_users';

    protected $dates = ['birthdate','timestamp'];

    public function checkEmailFormat(){
        if (filter_var($this->email_personal, FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
        
    }
}
