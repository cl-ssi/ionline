<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\User;

class RecordToCourt extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 
        'document_date', 
        'observation',
        'reception_id', 
        'user_id', 
        'manager_id', 
        'lawyer_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['document_date', 'deleted_at'];

    protected $table = 'drg_record_to_court';

    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

}
