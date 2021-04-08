<?php

namespace App\Models\RequestFormDocuments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestFormDocuments\RequestService;

class RequestFormDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'justification', 'program'
    ];

    public function requestServices(){
      return $this->hasMany(RequestService::class);
    }
}
