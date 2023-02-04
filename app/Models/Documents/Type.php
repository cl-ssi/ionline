<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Documents\Signature;
use App\Models\Documents\Parte;
use App\Models\Documents\Document;


class Type extends Model
{
    use HasFactory, SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'doc_digital',
        'partes_exclusive',
        'description',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'doc_types';
    
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function partes()
    {
        return $this->hasMany(Parte::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

}
