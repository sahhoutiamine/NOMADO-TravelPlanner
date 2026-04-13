<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name', 'description', 'image'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
