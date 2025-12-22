<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 
        'route_points', 
        'total_distance'
    ];

    // JSON data auto array convert
    protected $casts = [
        'route_points' => 'array',
        'total_distance' => 'float',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}