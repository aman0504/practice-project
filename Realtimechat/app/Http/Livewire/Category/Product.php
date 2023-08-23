<?php

namespace App\Http\Livewire\Category;

use App\Models\Product as ModelsProduct;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use App\Models\ProductSpecification;
use Livewire\Component;
use App\Models\Subcategory;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Product extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    // public $inputs = [''];
    // public $i = 1;

    public $title, $description, $categories, $subcategory, $image;
    public $spTitle, $spDescription, $products;
    public $features=[''];
    public $specification = [''];
    public $product_id, $productId;
    public $specificationTitle, $specificationDescrp;

    protected $listeners = ['addFeatures', 'addSpecification'];


    public function mount()
    {
        $this->products = ModelsProduct::with('productFeature', 'productSpecification')->get();
        // dd($this->products);

    }

    public function addFeatures()
    {
        if (count($this->features) < 6) {
            $this->features[] = '';
        }
    }

    public function removeFeatures($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function addSpecification()
    {
        if (count($this->specification) < 6) {
            $this->specification[] = '';
        }
    }

    public function removeSpecification($index)
    {
        unset($this->specification[$index]);
        $this->specification = array_values($this->specification);
    }

    public function store()
    {
        $product = new ModelsProduct();
        $product->title = $this->title;
        $product->description = $this->description;
        $product->save();

        if ($this->image) {
            $product->addMedia($this->image->getRealPath())
                ->toMediaCollection('image');
        }
        $this->productId = $product->id;

        if($this->features){
            $features = new ProductFeature();
            $features->products_id = $this->productId;
            $features->title = json_encode($this->features);   //save in array
            $features->save();
        }

        if($this->specificationTitle){
            $specification = new ProductSpecification();
            $specification->products_id = $this->productId;
            $specification->title = json_encode($this->specificationTitle);
            // dd($specification->title );
            $specification->description = json_encode($this->specificationDescrp);
            $specification->save();
        }

        if($this->productId){
            $products = new ProductCategory();
            $products->products_id = $this->productId;
            $products->subcategories_id =$this->subcategory;
            $products->save();
        }

        $this->alert('success', 'Products saved successfully.');
    }



    public function render()
    {
        $subCategory =  Subcategory::get();
        return view('livewire.category.product', compact('subCategory'));
    }
}
