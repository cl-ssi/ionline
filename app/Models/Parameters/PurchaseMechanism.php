<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\Parameters\PurchaseType;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseMechanism extends Model
{
  use HasFactory;
  use SoftDeletes;

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

  public function getPurchaseMechanismValueAttribute(){
      switch ($this->name) {
          case "MENORES A 3 UTM":
              return 'Menores a 3 U.T.M.';
              break;

          case "CONVENIO MARCO":
              return 'Convenio Marco';
              break;

          case "TRATO DIRECTO":
              return 'Trato Directo';
              break;

          case "LICITACIÓN PÚBLICA":
              return 'Licitación Pública';
              break;

          case "COMPRA ÁGIL (TRATO DIRECTO)":
              return 'Compra Ágil (Trato Directo)';
              break;
      }
  }

  protected $table = 'cfg_purchase_mechanisms';

}
