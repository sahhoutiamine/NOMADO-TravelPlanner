<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomActivity extends Model
{
    protected $table = 'booking_custom_activities';

    protected $fillable = [
        'booking_id',
        'name',
        'budget',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
