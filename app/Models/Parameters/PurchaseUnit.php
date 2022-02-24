<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseUnit extends Model
{
  protected $fillable = [ 'name'];

  public function requestForms() {
      return $this->hasMany(RequestForm::class, 'purchase_unit_id');
  }

  public function purchasingProcesses() {
      return $this->hasMany(PurchasingProcess::class, 'purchase_unit_id');
  }


  public function getName(){
    return $this->name ? $this->name : ' ';
  }

    use HasFactory;
    use SoftDeletes;
    protected $table = 'cfg_purchase_units';
}
