<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'specialization', 'duration'];

    public function queues()
    {
        return $this->hasMany(Queue::class, 'service_id');
    }
}