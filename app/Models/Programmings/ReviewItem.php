<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReviewItem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'pro_review_items';

    protected $fillable = [
        'id','review_id', 'review', 'answer', 'observation', 'active', 'user_id', 'rectified', 'rect_comments', 'updated_by', 'programming_item_id'
    ];

    public function programItem()
    {
        return $this->belongsTo('App\Models\Programmings\ProgrammingItem', 'programming_item_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();
    }

    public function reviewer()
    {
        return $this->belongsTo('App\Models\User', 'updated_by')->withTrashed();
    }
}
