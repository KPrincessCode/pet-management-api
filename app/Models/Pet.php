<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'type',
        'age',
        'medicine_needed',
        'injection_status',
        'owner_name'
    ];
}