<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Itemable extends MorphPivot
{
    public $table = 'itemables';
    
    public $incrementing = true;

    protected $fillables = [
        'item_id',
        'quantity',
        'measurement_unit_id',
    ];

    public function trail() {
        return $this->hasOne(Trail::class, 'itemable_id', 'id');
    }
}
