<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Itemable extends MorphPivot
{
    public $incrementing = true;

    protected $fillables = [
        'item_id',
        'quantity',
        'measurement_unit_id',
    ];
}
