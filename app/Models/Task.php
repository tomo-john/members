<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'due_date',
        'is_done',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_done' => 'boolean',
    ];
}
