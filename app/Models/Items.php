<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Formulario;

class Items extends Model
{
    use HasFactory;
    protected $fillable=['articulo'];
    public function formulario(){
      return $this->belongsTo(Formulario::Class);
    }
}
