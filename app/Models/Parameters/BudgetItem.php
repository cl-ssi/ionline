<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'code', 'name'];

    protected $table = 'arq_budget_items';
}
