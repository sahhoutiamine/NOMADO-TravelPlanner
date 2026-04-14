<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id', 'name', 'price_per_night', 'description',
        'localisation', 'contact_number', 'email', 'type', 'image',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'luxury'    => '⭐ Luxe',
            'mid-range' => '🏨 Milieu de gamme',
            'economy'   => '💰 Économique',
            'budget'    => '🎒 Budget',
            'boutique'  => '🌸 Boutique',
            'resort'    => '🏝️ Resort',
            default     => '🏨 Hôtel',
        };
    }
}
