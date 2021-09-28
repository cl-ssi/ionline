<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceRequests\Fulfillment;

class Denomination1121 extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'doc_denominations_1121';

    protected $fillable = [
      'id', 'code', 'pavilion', 'denomination', 'eq',

      'anest_level1_aport', 'anest_level1_value',
      'anest_level2_aport', 'anest_level2_value',
      'anest_level3_aport', 'anest_level3_value',

      'surgical_level1_aport', 'surgical_level1_value',
      'surgical_level2_aport', 'surgical_level2_value',
      'surgical_level3_aport', 'surgical_level3_value',

      'procedure_level1_aport', 'procedure_level1_value',
      'procedure_level2_aport', 'procedure_level2_value',
      'procedure_level3_aport', 'procedure_level3_value',
    ];

    public function Fulfillments()
    {
        return $this->belongsToMany(Fulfillment::class, 'doc_1121_fulfillments', 'doc_fulfillments_id', 'doc_1121_id')->withTimestamps();
    }
}
