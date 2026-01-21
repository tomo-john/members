<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sandbox extends Model
{
    protected $fillable = [
        'name',
        'is_active',
        'scheduled_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'scheduled_at' => 'datetime',
    ];
}
