<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryHistoryLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_number',
        'latitude',
        'longitude'
    ];
}
