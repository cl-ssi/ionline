<?php

namespace App\Models\Resources;

use App\Models\Inv\InventoryLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ComputerLabel extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_computer_label';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'computer_id',
        'label_id',
    ];

    /**
     * Get the computer associated with the label.
     */
    public function computer(): BelongsTo
    {
        return $this->belongsTo(Computer::class);
    }

    /**
     * Get the label associated with the computer.
     */
    public function label(): BelongsTo
    {
        return $this->belongsTo(InventoryLabel::class);
    }
}
