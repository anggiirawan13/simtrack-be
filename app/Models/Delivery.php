<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_number',
        'company_name',
        'shipper_id',
        'status',
        'delivery_date',
        'receive_date',
        'confirmation_code',
        'created_by',
        'updated_by'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'delivery_number');
    }

    public function history()
    {
        return $this->hasMany(DeliveryHistoryLocation::class, 'delivery_number');
    }
}
