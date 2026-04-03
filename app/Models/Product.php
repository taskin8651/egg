<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'type',
        'price',
        'bulk_price',
        'min_order_qty',
        'stock',
        'description',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // 🔥 Media Collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')->singleFile();
    }
}