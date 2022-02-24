<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\RequestForm;
use App\Models\Parameters\PurchaseMechanism;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseType extends Model
{
  protected $fillable = [ 'name', 'finance_business_day', 'supply_continuous_day' ];

/*
  public function requestForms() {
      return $this->hasMany(RequestForm::class);
  }
*/
  public function purchasingProcesses() {
      return $this->hasMany(PurchasingProcess::class, 'purchase_type_id');
  }

  public function requestForms() {
      return $this->hasMany(RequestForm::class, 'purchase_type_id');
  }

  public function purchaseMechanisms()
  {
      return $this->belongsToMany(PurchasingMechanism::class, 'cfg_purchase_mechanism_type', 'purchase_mechanism_id', 'purchase_type_id')->withTimestamps();
  }

  public function getName(){
    return $this->name ? $this->name : '';
  }

    use HasFactory;
    use SoftDeletes;
    protected $table = 'cfg_purchase_types';

}
