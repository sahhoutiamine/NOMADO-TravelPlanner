<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city_id', 'trip_type', 'departure_city_id',
        'budget_total', 'duration', 'passengers', 'departure_date',
        'flight_budget', 'hotel_budget', 'activities_budget', 'misc_budget',
        'status', 'selected_place_ids', 'include_hotel',
        'flight_airline', 'flight_class', 'flight_duration', 'share_code',
    ];

    protected $casts = [
        'departure_date' => 'date',
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

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'booking_hotel')->withPivot('check_in_date', 'check_out_date')->withTimestamps();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'booking_user')->withPivot('isOwner')->withTimestamps();
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'booking_place')->withPivot('visit_date')->withTimestamps();
    }

    public function customActivities()
    {
        return $this->hasMany(CustomActivity::class);
    }

    public function getCustomActivitiesBudgetAttribute()
    {
        return $this->customActivities()->sum('budget');
    }
}
