<?php

namespace App\Models\Suitability;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'psi_signers';

        protected $dates = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        protected $fillable = [
        'user_id',
        'sign_order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
