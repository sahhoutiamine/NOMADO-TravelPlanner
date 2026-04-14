<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name', 'description', 'image', 'localisation'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'city_id', 'id', 'cities', 'country_id');
    }

    public function hotels()
    {
        // This assumes a place can have related hotels if we want to show them
        // For now, let's keep it consistent with what the controller or seeder expects
        return $this->city->hotels();
    }
}
