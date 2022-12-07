<?php

namespace App\Models\Drugs;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Destruction extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reception_id',
        'police',
        'destructed_at',
        'user_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'destructed_at',
        'deleted_at',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_destructions';

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

    public function observer()
    {
        return $this->belongsTo(User::class, 'observer_id');
    }

    public function lawyer_observer()
    {
        return $this->belongsTo(User::class, 'lawyer_observer_id');
    }

}
