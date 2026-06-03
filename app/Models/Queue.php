<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'queue_number',
        'customer_name',
        'phone',
        'vehicle_id',
        'vehicle_name',
        'service_id',
        'mechanic_id',
        'status',
        'total_price',
        'start_time',
        'end_time',
    ];

   public static function activeCountForMechanic($mechanicId)
    {
        return static::where('mechanic_id', $mechanicId)
            ->whereIn('status', ['waiting', 'processing']) // ganti ini
            ->count();
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}