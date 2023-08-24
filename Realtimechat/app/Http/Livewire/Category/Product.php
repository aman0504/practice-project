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

    public $title, $description, $categories, $image;
    public $spTitle, $spDescription, $products;
    public $features = [''];
    public $specification = [''];
    public $product_id, $productId;
    public $specificationTitle, $specificationDescrp;
    public $subcategory = [];

    protected $listeners = ['addFeatures', 'addSpecification', 'confirmedDelete'];

    public function mount()
    {
        // Load existing products with subcategories
        $this->products = ModelsProduct::with('subCategories')->get();
    }

    public function rules()
    {
        // Validation rules for form fields
        return [
            'title' => 'required|unique:products,title', // Change 'categories' to 'products'
            'description' => 'required',
            'image' => 'required|image|max:2048', // Added image validation
            'subcategory' =>'required',
            'features.*' => 'required', // Validate each feature input
            'specificationTitle.*' => 'required', // Validate each specification title
            'specificationDescrp.*' => 'nullable', // Allow nullable description
        ];
    }

    // Feature-related methods
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

    // Specification-related methods
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
        // Validate form inputs
        $this->validate();

        // Create a new product
        $product = new ModelsProduct();
        $product->title = $this->title;
        $product->description = $this->description;
        $product->save();

        // Add image to the product
        if ($this->image) {
            $product->addMedia($this->image->getRealPath())
                ->toMediaCollection('image');
        }

        // Save product features
        if ($this->features) {
            $productFeatures = [];
            foreach ($this->features as $feature) {
                $productFeatures[] = [
                    'products_id' => $product->id,
                    'title' => $feature,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            ProductFeature::insert($productFeatures);
        }

        // Save product specifications
        $specificationData = [];
        foreach ($this->specificationTitle as $index => $title) {
            $specificationData[] = [
                'products_id' => $product->id,
                'title' => $title,
                'description' => $this->specificationDescrp[$index] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        ProductSpecification::insert($specificationData);

        // Associate product with subcategories
        if ($product->id) {
            $products = new ProductCategory();
            $products->products_id = $product->id;
            $products->subcategories_id = $this->subcategory;
            $products->save();
        }

        // Show success alert
        $this->alert('success', 'Product saved successfully.');
    }

    // Delete confirmation
    public function delete($id)
    {
        $this->product_id = $id;

        // Show delete confirmation alert
        $this->alert('warning', 'Are you sure you want to delete?', [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Delete it',
            'onConfirmed' => 'confirmedDelete',
            'timer' => null
        ]);
    }

    // Confirmed deletion action
    public function confirmedDelete()
    {
        // Find the product and delete
        $product = ModelsProduct::findOrFail($this->product_id);
        $product->delete();
        // Show success alert after deletion
        $this->alert('success', 'Product deleted successfully');
    }


    public function render()
    {
        // Load subcategories for select dropdown
        $subCategory =  Subcategory::get();
        return view('livewire.category.product', compact('subCategory'));
    }

}
