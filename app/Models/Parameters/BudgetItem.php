<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForm\ItemRequestForm;

class BudgetItem extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'code', 'name'];

    public function itemRequestForms() {
        return $this->hasMany(ItemRequestForm::class, 'budget_item_id');
    }


    protected $table = 'arq_budget_items';
}
