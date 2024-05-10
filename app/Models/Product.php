<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'stock',
        'status',
        'images',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getImagesAttribute($value)
{
    // Get the image file names from the storage folder
    $imageFiles = json_decode($value);

    // Map each file name to its public URL

        return collect($imageFiles)->map(function ($file) {
        // Convert the storage path to a public URL
        return \Storage::url($file);
    });
}
}
