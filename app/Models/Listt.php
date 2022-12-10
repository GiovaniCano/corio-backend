<?php

namespace App\Models;

use App\Models\Traits\HasItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listt extends Model
{
    use HasFactory, HasItems;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $with = ['items.pivot.measurementUnit', 'items.pivot.trail'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
