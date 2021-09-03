<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\Parameters\PurchaseType;

class PurchaseMechanism extends Model
{
  use HasFactory;

  protected $fillable = ['id', 'name'];
/*
  public function itemRequestForms() {
      return $this->hasMany(ItemRequestForm::class, 'purchase_mechanism_id');
  }
*/
  public function requestForms() {
      return $this->hasMany(RequestForm::class, 'purchase_mechanism_id');
  }

  public function purchasingProcesses() {
      return $this->hasMany(PurchasingProcess::class, 'purchase_mechanism_id');
  }

  public function purchaseTypes()
  {
      return $this->belongsToMany(PurchaseType::class, 'cfg_purchase_mechanism_type', 'purchase_mechanism_id', 'purchase_type_id')->withTimestamps();
  }

  protected $table = 'cfg_purchase_mechanisms';

}
