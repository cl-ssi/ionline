<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\ItemRequestForm;

class PurchaseUnit extends Model
{
  protected $fillable = [ 'name' ];

  public function requestForms() {
      return $this->hasMany(RequestForm::class, 'purchase_unit_id');
  }

  public function itemRequestForms() {
      return $this->hasMany(ItemRequestForm::class, 'purchase_unit_id');
  }


  public function getName(){
    return $this->name ? $this->name : ' ';
  }

    use HasFactory;
    protected $table = 'cfg_purchase_units';
}
