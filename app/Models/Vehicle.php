<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'colors',
        'sizes',
        'base_price',
    ];

    protected $casts = [
        'colors' => 'json', 
        'sizes' => 'json',  
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vehicle')
                    ->withPivot('color', 'size', 'price')
                    ->withTimestamps();
    }
}
