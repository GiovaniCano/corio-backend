<?php

namespace App\Models\Traits;

trait HasItems {  

    public function items() {
        return $this->morphToMany(Item::class, 'itemable')
                    ->using(Itemable::class)
                    ->withPivot('item_id', 'quantity', 'measurement_unit_id')
                    ->withTimestamps();
    }
    
}