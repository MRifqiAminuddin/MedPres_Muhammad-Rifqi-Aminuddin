<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    protected $fillable = [
        'encounter_id',
        'status',
        'prescription_date',
        'identity'
    ];

    public function encounter(): BelongsTo
    {
        return $this->belongsTo(Encounter::class, 'encounter_id', 'id');
    }

    public function prescriptionMedicines(): HasMany
    {
        return $this->hasMany(PrescriptionMedicine::class, 'prescription_id', 'id');
    }
}
