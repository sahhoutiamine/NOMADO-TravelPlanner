<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_banned',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_user')->withPivot('isOwner')->wherePivot('isOwner', true)->withTimestamps();
    }

    public function sharedBookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_user')->withPivot('isOwner')->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTravlerAdmin()
    {
        return $this->role === 'travlerAdmin';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
        ];
    }
}
