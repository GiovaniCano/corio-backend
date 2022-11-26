<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'measurement_type_id',
    ];

    protected $with = ['measurementType'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function measurementType() {
        return $this->belongsTo(MeasurementType::class);
    }
}
