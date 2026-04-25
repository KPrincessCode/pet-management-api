<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;

class Booking extends Model
{
    protected $fillable = [
        'pet_id',
        'owner_name',
        'service_type',
        'pet_type',
        'medicine_needed',
        'injection_status',
        'check_in_date',
        'check_out_date',
        'payment_amount',
        'payment_status',
        'status',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}