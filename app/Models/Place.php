<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'city',
        'trip_type',
        'description',
        'image',
        'rating',
    ];

    /**
     * Get the country that owns the place.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}
