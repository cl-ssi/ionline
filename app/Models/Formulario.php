<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Items;


class Formulario extends Model
{
    use HasFactory;
    protected $fillable=['titulo'];

    public function items(){
      return $this->hasMany(Items::Class);
    }
}
