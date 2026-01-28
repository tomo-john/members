<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sandbox extends Model
{
    protected $fillable = [
        'name',
        'is_good_boy',
        'birthday',
        'mood',
    ];

    protected $casts = [
        'is_good_boy' => 'boolean',
        'birthday' => 'datetime',
    ];
}
