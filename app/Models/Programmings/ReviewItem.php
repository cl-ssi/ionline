<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewItem extends Model
{
    use HasFactory;

    protected $table = 'pro_review_items';

    protected $fillable = [
        'id','review_id', 'review', 'answer', 'observation', 'active', 'user_id', 'rectified', 'updated_by', 'programming_item_id'
    ];

    public function programItem()
    {
        return $this->belongsTo('App\Programmings\ProgrammingItem', 'programming_item_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function reviewer()
    {
        return $this->belongsTo('App\User', 'updated_by')->withTrashed();
    }
}
