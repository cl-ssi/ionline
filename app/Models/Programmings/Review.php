<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'pro_programming_reviews';

    protected $fillable = [
        'id','revisor', 'general_features', 'answer', 'observation', 'active', 'user_id', 'updated_by', 'programming_id'
    ];


    // public function programming() {
    //     return $this->belongsTo('App\Programmings\Programming');
    // }

    public function communeFile() {
        return $this->belongsTo('App\Models\Programmings\CommuneFile');
    }
}
