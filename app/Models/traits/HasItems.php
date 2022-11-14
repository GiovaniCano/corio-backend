<?php

namespace App\Models\Traits;

use App\Models\Item;
use App\Models\Itemable;

trait HasItems {  

    public function items() {
        return $this->morphToMany(Item::class, 'itemable')
                    ->using(Itemable::class)
                    ->withPivot('quantity', 'measurement_unit_id')
                    ->withTimestamps();
    }
    
}