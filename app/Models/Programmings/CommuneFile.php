<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CommuneFile extends Model
{
    use HasFactory;

    protected $table = 'pro_commune_files';

    protected $fillable = [
        'id','year', 'description', 'access', 'file_a', 'file_b','file_c','observation','status', 'user_id', 'commune_id'
    ];

    protected $casts = [
        'access' => 'array'
    ];

    public function commune() {
        return $this->belongsTo('\App\Models\Commune');
    }

    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function programming_reviews() {
        return $this->hasMany('App\Models\Programmings\Review');
    }

    public function getReviewsCountBy($revisor)
    {
        return $this->programming_reviews->filter(function ($review) use ($revisor){
            return Str::contains($review->revisor, $revisor); 
        })->count() + ($revisor == 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES' ? 2 : 0);
    }

    public function isLastReviewBy($revisor, $item)
    {
        $reviews = $this->programming_reviews->filter(function ($review) use ($revisor){
            return Str::contains($review->revisor, $revisor); 
        });
        return $reviews->last() == $item;
    }
}