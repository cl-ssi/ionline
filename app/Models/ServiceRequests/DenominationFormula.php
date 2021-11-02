<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceRequests\Fulfillment;

class DenominationFormula extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'doc_denominations_formula';

    protected $fillable = [
      'id', 'code', 'pavilion', 'denomination', 'eq',

      'surgical1_level1', 'surgical1_level2', 'surgical1_level3',
      'surgical2_level1', 'surgical2_level2', 'surgical2_level3',
      'surgical3_level1', 'surgical3_level2', 'surgical3_level3',
      'surgical4_level1', 'surgical4_level2', 'surgical4_level3',

      'anest1_level1', 'anest1_level2', 'anest1_level3',
    ];

    public function Fulfillments()
    {
        return $this->belongsToMany(Fulfillment::class, 'doc_formula_fulfillments', 'doc_fulfillments_id', 'doc_formula_id')->withTimestamps();
    }


}
