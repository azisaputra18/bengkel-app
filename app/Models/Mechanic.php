<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'code',
        'last_assigned_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate kode saat CREATE
        static::creating(function ($mechanic) {
            $mechanic->code = self::generateCode($mechanic->specialization);
        });

        // Update kode saat EDIT dan spesialisasi berubah
        static::updating(function ($mechanic) {
            if ($mechanic->isDirty('specialization')) {
                $mechanic->code = self::generateCode($mechanic->specialization);
            }
        });
    }

    // Helper generate kode
    private static function generateCode($specialization)
    {
        $prefix = strtoupper(substr($specialization, 0, 1));
        $count  = static::where('specialization', $specialization)->count();
        return $prefix . ($count + 1);
    }
}