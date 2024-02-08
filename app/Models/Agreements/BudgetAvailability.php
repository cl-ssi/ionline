<?php

namespace App\Models\Agreements;

use App\Models\Documents\Document;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetAvailability extends Model
{
    use SoftDeletes;

    public function program() {
        return $this->belongsTo(Program::class);
    }

    public function referrer() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function document() {
        return $this->belongsTo(Document::class);
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'res_minsal_number', 'res_minsal_date', 'program_id', 'referrer_id', 'document_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'res_minsal_date'];

    protected $table = 'agr_budget_availability';
}
