<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    public $table = 'psi_questions';


    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'category_id',
        'question_text',
    ];


    public function questionOptions()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    
}
