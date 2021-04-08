<?php

namespace App\Models\RequestFormDocuments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestFormDocuments\RequestFormDocument;
use App\Models\Parameters\UnitOfMeasurement;

class RequestService extends Model
{
    use HasFactory;

    protected $fillable = [
        'article', 'unitOfMeasurement', 'technicalSpecifications', 'quantity', 'unitValue', 'taxes', 'totalValue'
    ];

    public function requestFormDocument(){
      return $this->belongsTo(RequestFormDocument::class);
    }

    public function unitOfMeasurement(){
      return $this->belongsTo(UnitOfMeasurement::class);
    }

    public function getArticle(){
      return $this->article;
    }

    public function setArticle($article){
      $this->article = $article;
    }
}
