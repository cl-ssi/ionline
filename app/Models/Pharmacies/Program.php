<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_programs';

    /**
     * Get the products that owns the program.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
