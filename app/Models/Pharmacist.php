<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pharmacist extends Model
{
    protected $fillable = [
        'user_id',
        'str_number',
        'identity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function prescription(): HasMany
    {
        return $this->hasMany(Prescription::class, 'prescription_id', 'id');
    }

}
