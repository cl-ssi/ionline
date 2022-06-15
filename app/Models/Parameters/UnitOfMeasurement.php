<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitOfMeasurement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cfg_unit_of_measurements';

    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'prefix'];

    // public function RequestServices() {
    //     return $this->hasMany(RequestService::class);
    // }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];
}
