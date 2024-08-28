<?php

namespace App\Models;

use App\Models\Suitability\PsiRequest;
use App\Models\Suitability\Result;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class UserExternal extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_external';

    /**
     * The guard associated with the model.
     *
     * @var string
     */
    protected $guard = 'external';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'dv',
        'fathers_family',
        'mothers_family',
        'position',
        'gender',
        'address',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the results for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userResults(): HasMany
    {
        return $this->hasMany(Result::class, 'user_id', 'id');
    }

    /**
     * Get the psi requests for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function psiRequests(): HasMany
    {
        return $this->hasMany(PsiRequest::class, 'user_external_id', 'id');
    }

    /**
     * Get the formatted run.
     *
     * @return string
     */
    public function getRunFormatAttribute(): string
    {
        return number_format($this->id, 0, '.', '.') . '-' . $this->dv;
    }

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->fathers_family} {$this->mothers_family}";
    }
}