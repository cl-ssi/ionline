<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\RequestForm;

class PurchaseMechanism extends Model
{
  use HasFactory;

  protected $fillable = ['id', 'name'];

  public function itemRequestForms() {
      return $this->hasMany(ItemRequestForm::class, 'purchase_mechanism_id');
  }

  public function requestForms() {
      return $this->hasMany(RequestForm::class, 'purchase_mechanism_id');
  }

  protected $table = 'cfg_purchase_mechanisms';

}
