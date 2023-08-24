<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategories_id', 'id');
    }
}
