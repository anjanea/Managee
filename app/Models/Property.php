<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'price',
        'stars',
        'address',
        'location',
        'image',
        'description',
        'bedrooms',
        'bathrooms',
        'area',
        'floors',
        'garage',
        'year_built',
        'certificate',
        'electricity',
        'water_source',
        'facilities',
        'images',
        'views',
    ];

    protected $casts = [
        'facilities' => 'array',
        'images' => 'array',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
