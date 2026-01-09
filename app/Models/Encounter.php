<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encounter extends Model
{
    protected $table = 'encounters';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_id',
        'body_height',
        'body_weight',
        'systole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'body_temperature',
        'anamnesis',
        'diagnosis',
        'other_document',
        'encounter_date'
    ];

    protected $casts = [
        'body_height'        => 'integer',
        'body_weight'        => 'decimal:1',
        'systole'            => 'integer',
        'diastole'           => 'integer',
        'heart_rate'         => 'integer',
        'respiration_rate'   => 'integer',
        'body_temperature'   => 'decimal:1',
    ];


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
