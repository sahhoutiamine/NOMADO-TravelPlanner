<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'start_date',
        'departure_country',
        'departure_city',
        'total_amount',
        'is_flight_paid',
        'is_hotel_paid',
        'airline',
        'flight_departure',
        'flight_arrival',
        'flight_duration',
    ];

    protected $casts = [
        'start_date' => 'date',
        'is_flight_paid' => 'boolean',
        'is_hotel_paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
