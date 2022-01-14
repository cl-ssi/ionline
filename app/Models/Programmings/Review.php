<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'pro_programming_reviews';

    protected $fillable = [
        'id','revisor', 'general_features', 'score', 'answer', 'observation', 'active', 'user_id', 'updated_by', 'programming_id'
    ];

    public function communeFile() {
        return $this->belongsTo('App\Models\Programmings\CommuneFile');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by')->withTrashed();
    }
}
