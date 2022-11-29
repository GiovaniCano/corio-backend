<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $with = ['daySections'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function daySections() {
        return $this->hasMany(DaySection::class)->orderBy('name');
    }
}
