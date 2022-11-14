<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trail extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'itemable_id',
        'trail',
    ];
}
