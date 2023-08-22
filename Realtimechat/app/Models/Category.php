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
        return $this->hasMany(Subcategory::class,'categories_id','id');
    }

}
