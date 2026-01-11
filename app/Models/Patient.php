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
        'name',
        'birth_date',
        'identity'
    ];

    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class, 'patient_id', 'id');
    }
}
