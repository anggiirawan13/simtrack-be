<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp',
        'street',
        'sub_district',
        'district',
        'city',
        'province',
        'postal_code'
    ];

    public $timestamps = false;
}
