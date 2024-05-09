<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status',
        'images',
    ];

    public function getImagesAttribute($value)
{
    // Get the image file names from the storage folder
    $imageFiles = \Storage::files('public/products');

    // Map each file name to its public URL
    return collect($imageFiles)->map(function ($file) {
        // Convert the storage path to a public URL
        return \Storage::url($file);
    });
}
}
