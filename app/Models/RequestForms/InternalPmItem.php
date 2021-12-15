<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\InternalPurchaseOrder;
use App\Models\RequestForms\ItemRequestForm;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class InternalPmItem extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    public $table = "arq_internal_pm_items";

    protected $fillable = [
        'quantity', 'unit_value', 'expense', 'status'
    ];

    public function internalPurchaseOrder() {
        return $this->belongsTo(RequestForm::class);
    }

    public function item() {
        return $this->belongsTo(ItemRequestForm::class);
    }

    public function formatExpense()
    {
      return number_format($this->expense,0,",",".");
    }
}
