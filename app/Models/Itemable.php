<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Itemable extends MorphPivot
{
    protected $table = 'itemables';
    
    public $incrementing = true;

    protected $fillables = [
        'item_id',
        'quantity',
        'measurement_unit_id',
    ];

    // protected $with = ['measurementUnit'];
    // protected $with = ['trail'];

    public function trail() {
        return $this->hasOne(Trail::class, 'itemable_id', 'id');
    }
    
    public function measurementUnit() {
        return $this->belongsTo(MeasurementUnit::class);
    }

    // public function item() {
    //     return $this->belongsTo(Item::class);
    // }
    
}
