<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'place_id',
        'hotel_id',
        'trip_type',
        'budget_total',
        'duration',
        'passengers',
        'flight_budget',
        'hotel_budget',
        'activities_budget',
        'misc_budget',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
