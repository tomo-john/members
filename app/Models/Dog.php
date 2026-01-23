<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $fillable = [
        'name',
        'birthday',
        'is_good_boy',
    ];

    protected $casts = [
        'birthday' => 'date',
        'is_good_boy' => 'boolean',
    ];
}
