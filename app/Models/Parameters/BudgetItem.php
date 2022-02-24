<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForm\ItemRequestForm;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id', 'code', 'name'];

    public function itemRequestForms() {
        return $this->hasMany(ItemRequestForm::class, 'budget_item_id');
    }

    public function fullName(){
      return $this->code.' '.$this->name;
    }

    protected $table = 'cfg_budget_items';
}
