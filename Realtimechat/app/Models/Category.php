<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Subcategory as ModelsSubcategory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subcategory()
    {
        return $this->hasMany(Subcategory::class, 'categories_id', 'id');
    }

    // public function product()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_categories');
    // }

}
