<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RequestForms\RequestForm;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDoc extends Model
{
    use HasFactory;
    use softDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'arq_payment_docs';
    

    public function requestForm()
    {
        return $this->belongsTo(RequestForm::class);
    }
    
}
