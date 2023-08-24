<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Subcategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class,'categories_id','id' );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'products_id','subcategories_id');
    }
}
