<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrescriptionMedicine extends Model
{
    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'dosage',
        'status',
    ];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
    }
}
