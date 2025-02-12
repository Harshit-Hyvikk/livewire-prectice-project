<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $fillable = ['message', 'type', 'read'];

    protected $casts = [
        'read' => 'boolean',
    ];
}
