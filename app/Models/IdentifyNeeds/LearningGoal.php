<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class LearningGoal extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description', 'identify_need_id'
    ];

    public function identifyNeed() {
        return $this->belongsTo('App\Models\IdentifyNeeds\IdentifyNeed', 'identify_need_id')->withTrashed();
    }

    protected $table = 'dnc_learning_goals';
}
