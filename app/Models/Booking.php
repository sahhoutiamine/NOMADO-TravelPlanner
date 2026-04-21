<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city_id', 'hotel_id', 'trip_type',
        'budget_total', 'duration', 'passengers',
        'flight_budget', 'hotel_budget', 'activities_budget', 'misc_budget',
        'total_price', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
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
