<?php

namespace App\Models\Welfare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'well_loans';

    protected $fillable = [
        'folio', 'rut', 'names', 'date', 'number', 'late_number', 'late_interest', 'late_amortization', 'late_value'
    ];
}
