<?php

namespace App\Models\Pharmacies;

use App\Models\Pharmacies\Destiny;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deliver extends Model
{
    protected $fillable = [
        'destiny_id', 'product_id', 'invoice', 'request_date', 'due_date', 'patient_rut', 
        'patient_name', 'age', 'request_type', 'quantity', 'diagnosis', 'doctor_name', 'remarks'
    ];

    protected $table = 'frm_deliveries';

    /**
     * Get the user that created the receiving.
     *
     * @return BelongsTo
     */
    public function destiny(): BelongsTo
    {
        return $this->belongsTo(Destiny::class);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Pharmacies\Product');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Documents\Document');
    }
}
