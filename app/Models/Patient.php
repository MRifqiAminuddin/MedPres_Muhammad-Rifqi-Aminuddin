<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'medical_record_number',
        'name',
        'birth_date',
        'identity'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class, 'patient_id', 'id');
    }
}
