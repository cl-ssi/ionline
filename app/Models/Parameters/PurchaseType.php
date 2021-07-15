<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\RequestForm;

class PurchaseType extends Model
{
  protected $fillable = [ 'name' ];

/*
  public function requestForms() {
      return $this->hasMany(RequestForm::class);
  }
*/
  public function itemRequestForms() {
      return $this->hasMany(ItemRequestForm::class, 'purchase_type_id');
  }

  public function requestForms() {
      return $this->hasMany(RequestForm::class, 'purchase_type_id');
  }


  public function getName(){
    return $this->name ? $this->name : '';
  }

    use HasFactory;
    protected $table = 'cfg_purchase_types';

}
