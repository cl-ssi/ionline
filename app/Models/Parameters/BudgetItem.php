<?php

namespace App\Models\Parameters;

use App\Models\RequestForms\ItemRequestForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cfg_budget_items';

    protected $fillable = [
        'id',
        'code',
        'name',
    ];

    public function itemRequestForms(): HasMany
    {
        return $this->hasMany(ItemRequestForm::class, 'budget_item_id');
    }

    public function fullName()
    {
        return $this->code.' '.$this->name;
    }
}
