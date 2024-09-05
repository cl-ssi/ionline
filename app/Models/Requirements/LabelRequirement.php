<?php

namespace App\Models\Requirements;

use App\Models\Requirements\Label;
use App\Models\Requirements\Requirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LabelRequirement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'req_labels_requirements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requirement_id',        
        'label_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'limit_at' => 'date',
    ];

    /**
     * Get the labels for the label requirement.
     *
     * @return BelongsToMany
     */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }

    /**
     * Get the requirements for the label requirement.
     *
     * @return BelongsToMany
     */
    public function requirements(): BelongsToMany
    {
        return $this->belongsToMany(Requirement::class);
    }
}