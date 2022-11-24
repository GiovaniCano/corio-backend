<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $with = ['avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar() {
        return $this->belongsTo(Avatar::class);
    }

    public function days() {
        return $this->hasMany(Day::class);
    }

    public function dishes() {
        return $this->hasMany(Dish::class);
    }

    public function lists() {
        return $this->hasMany(Listt::class);
    }
    
    public function items() {
        return $this->hasMany(Item::class);
    }

    public function measurementUnits() {
        return $this->hasMany(MeasurementUnit::class);
    }
}
