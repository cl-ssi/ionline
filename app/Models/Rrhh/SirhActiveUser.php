<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SirhActiveUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sirh_active_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'dv',
        'name',
        'email',
        'birthdate',
        'start_contract_date',
        'end_contract_date',
        'legal_quality',
        'ou_description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthdate'           => 'date',
        'start_contract_date' => 'date',
        'end_contract_date'   => 'date'
    ];

    /**
     * Check if the email format is valid.
     *
     * @return bool
     */
    public function checkEmailFormat(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }
}