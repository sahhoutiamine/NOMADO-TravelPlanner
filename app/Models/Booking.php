<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city_id', 'hotel_id', 'trip_type', 'departure_city_id',
        'budget_total', 'duration', 'passengers',
        'flight_budget', 'hotel_budget', 'activities_budget', 'misc_budget',
        'status', 'selected_place_ids', 'include_hotel',
        'flight_airline', 'flight_class', 'flight_duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
