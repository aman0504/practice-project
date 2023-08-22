<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Subcategory;

class Product extends Component
{
    public $inputs = [];
    public $i = 1;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        $subCategory =  Subcategory::get();
        return view('livewire.category.product', compact('subCategory'));
    }
}
