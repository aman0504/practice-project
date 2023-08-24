<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function productCategory(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
        // return $this->belongsToMany(ProductCategory::class,'product_categories', 'products_id','subcategories_id');
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'product_categories');
    // }

    public function subCategories()
    {
        return $this->belongsToMany(Subcategory::class, 'product_categories', 'products_id','subcategories_id');
    }

}
