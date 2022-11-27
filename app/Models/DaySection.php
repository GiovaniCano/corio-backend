<?php

namespace App\Models;

use App\Models\Traits\HasItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaySection extends Model
{
    use HasItems, HasFactory;

    protected $fillable = [
        'name',
        'day_id',
        'user_id',
    ];

    protected $with = ['dishes', 'itemables'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function day() {
        return $this->belongsTo(Day::class);
    }
    
    public function dishes() {
        return $this->belongsToMany(Dish::class)->withPivot('id');
    }
}
