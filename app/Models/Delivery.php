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
        'status_id',
        'delivery_date',
        'receive_date',
        'confirmation_code',
        'created_by',
        'updated_by'
    ];

    public function recipient()
    {
        return $this->hasOne(DeliveryRecipient::class, 'delivery_number', 'delivery_number');
    }

    public function shipper()
    {
        return $this->hasOne(Shipper::class, 'id', 'shipper_id');
    }

    public function status()
    {
        return $this->hasOne(DeliveryStatus::class, 'id', 'status_id');
    }


    public function history()
    {
        return $this->hasMany(DeliveryHistoryLocation::class, 'delivery_number', 'delivery_number');
    }
}
