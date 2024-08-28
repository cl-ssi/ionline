<?php

namespace App\Models\ReplacementStaff;

use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\ReplacementStaff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_manage_id',
        'profession_manage_id',
        'experience',
        'file',
        'degree_date',
        'replacement_staff_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'degree_date' => 'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the replacement staff that owns the profile.
     * // FIXME This method should be named `replacementStaff` to follow the Laravel naming convention.
     * @return BelongsTo
     */
    public function replacement_staff(): BelongsTo
    {
        return $this->belongsTo(ReplacementStaff::class);
    }

    /**
     * Get the profile manage that owns the profile.
     * // FIXME: This method should be named `profileManage` to follow the Laravel naming convention.
     *
     * @return BelongsTo
     */
    public function profile_manage(): BelongsTo
    {
        return $this->belongsTo(ProfileManage::class);
    }

    /**
     * Get the profession manage that owns the profile.
     * // FIXME: This method should be named `professionManage` to follow the Laravel naming convention.
     *
     * @return BelongsTo
     */
    public function profession_manage(): BelongsTo
    {
        return $this->belongsTo(ProfessionManage::class);
    }

    /**
     * Get the years of degree attribute.
     * // FIXME: No necesitas pasear el degree_date a Carbon, puedes usar el método `diffInYears` directamente.
     *
     * @return int
     */
    public function getYearsOfDegreeAttribute(): int
    {
        $degreeDate = Carbon::parse($this->degree_date);
        $diff       = $degreeDate->diffInYears(Carbon::now()->toDateString());

        return $diff;
    }

    /**
     * Get the experience value attribute.
     *
     * @return string
     */
    public function getExperienceValueAttribute(): string
    {
        switch ( $this->experience ) {
            case 'managerial':
                return 'Directivo';
            case 'administrative management':
                return 'Gestión Administrativa';
            case 'healthcare':
                return 'Asistencial (clínica u hospitalaria)';
            case 'operations':
                return 'Operaciones';
            default:
                return '';
        }
    }
}