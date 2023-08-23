<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function productFeature()
    {
        return $this->hasMany(ProductFeature::class, 'products_id', 'id');
    }

    public function productSpecification()
    {
        return $this->hasMany(ProductSpecification::class, 'products_id', 'id');
    }

    public function ProductCategory()
    {

    }
}
