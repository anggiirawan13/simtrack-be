<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'name',
        'address_id'    
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
