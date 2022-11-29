<?php

namespace App\Models\Traits;

use App\Models\Item;
use App\Models\Itemable;

trait HasItems {  

    public function items() {
        return $this->morphToMany(Item::class, 'itemable')
                    ->using(Itemable::class)
                    ->withPivot('id', 'quantity', 'measurement_unit_id')
                    ->withTimestamps()
                    ->orderBy('name');
    }

    // public function itemables() {
    //     return $this->hasMany(Itemable::class, 'itemable_id', 'id')->where('itemable_type', self::class);
    // }
}