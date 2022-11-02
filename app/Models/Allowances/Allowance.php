<?php

namespace App\Models\Allowances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Allowance extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'resol_number', 'user_allowance_id', 'allowance_value_id','contractual_condition', 'level',
        'establishment_id', 'organizational_unit_allowance_id', 'place', 'reason',
        'overnight', 'passage', 'means_of_transport', 'origin_commune_id', 'destination_commune_id', 'round_trip', 
        'from', 'to', 'from_half_day', 'to_half_day', 'creator_user_id', 'creator_ou_id', 'document_date'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function userAllowance() {
        return $this->belongsTo('App\User', 'user_allowance_id')->withTrashed();
    }

    public function organizationalUnitAllowance() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_allowance_id');
    }

    public function userCreator() {
        return $this->belongsTo('App\User', 'creator_user_id')->withTrashed();
    }

    public function organizationalUnitCreator() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'creator_ou_id');
    }

    public function originCommune() {
        return $this->belongsTo('App\Models\ClCommune', 'origin_commune_id');
    }

    public function destinationCommune() {
        return $this->belongsTo('App\Models\ClCommune', 'destination_commune_id');
    }

    public function files() {
        return $this->hasMany('App\Models\Allowances\AllowanceFile', 'allowance_id');
    }

    public function allowanceValue() {
        return $this->belongsTo('App\Models\Parameters\AllowanceValue', 'allowance_value_id');
    }

    public function allowanceSigns() {
        return $this->hasMany('App\Models\Allowances\AllowanceSign', 'allowance_id');
    }

    public function getContractualConditionValueAttribute(){
        switch ($this->contractual_condition) {
            case 'to hire':
              return 'Contrata';
              break;
            case 'fee':
              return 'Honorarios';
              break;
            case '':
              return '';
              break;
        }
    }

    public function getRoundTripValueAttribute(){
        switch ($this->round_trip) {
            case 'round trip':
              return 'Ida, vuelta';
              break;
            case 'one-way only':
              return 'Ida';
              break;
            case '':
              return '';
              break;
        }
    }

    public function getTotalDaysAttribute(){
        $total_days = $this->from->diffInDays($this->to);
        if($this->from == $this->to){
            if($this->from_half_day == 1 || $this->to_half_day == 1){
                $total_days = 0.5;
            }
            else{
                $total_days = 1;
            }
            return $total_days;
        }
        else{
            if($this->from_half_day == 1){
                $total_days = $total_days - 0.5;
            }
            if($this->to_half_day == 1){
                $total_days = $total_days - 0.5;
            }
            return $total_days + 1;
        }
    }

    public function getTotalIntDaysAttribute(){
        $total_int_days = intval($this->getTotalDaysAttribute());
        return $total_int_days;
    }

    public function getTotalIntAllowanceValueAttribute(){
        $total_int_allowance_value = $this->getTotalIntDaysAttribute() * $this->AllowanceValue->value;
        return number_format($total_int_allowance_value, 0, ",", ".");
    }

    public function getTotalDecimalDayAttribute(){
        $decimal_day = $this->getTotalDaysAttribute() - $this->getTotalIntDaysAttribute();
        return $decimal_day;
    }

    public function getTotalDecimalAllowanceValueAttribute(){
        $total_decimal_allowance_value = $this->AllowanceValue->value * 0.4;
        return number_format($total_decimal_allowance_value, 0, ",", ".");
    }

    public function getAllowanceValueFormatAttribute(){
        return number_format($this->AllowanceValue->value, 0, ",", ".");
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'from', 'to', 'document_date'
    ];

    protected $table = 'alw_allowances';
}