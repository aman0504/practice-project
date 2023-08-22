<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category as ModelsCategory;
use App\Models\Subcategory as ModelsSubcategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Subcategory extends Component
{
    use LivewireAlert;
    public $categories_id, $title, $subCategories , $image, $subcategory_id;
    public $subCat;

    protected $listeners = ['confirmedDelete'];

    public function mount()
    {
        $this->subCategories = ModelsSubcategory::with('category')->get();

    }

    public function resetInput()
    {
        $this->title = '';
        $this->image = '';
        $this->categories_id = '';
        $this->subcategory_id = '';
    }

    public function showModelSubcategory()
    {
        $this->emit('showModelSubcategory');
    }

    public function closeModel()
    {
        $this->emit('hideModelSubcategory');
    }

    public function store()
    {
        // validation pending here
        $subCategory = new ModelsSubcategory();
        $subCategory->categories_id = $this->categories_id;
        $subCategory->title = $this->title;
        $subCategory->save();

        $this->resetInput();
        $this->closeModel();
        $this->alert('success', 'Sub-Category saved successfully.');

    }

    public function edit($id)
    {
        $this->subCat = ModelsSubcategory::find($id);
        $this->subcategory_id= $this->subCat->id;
        $this->title = $this->subCat->title;
        $this->categories_id = $this->subCat->categories_id;

        $this->emit('showModelSubcategory');

    }

    public function update(){

    }

    public function deleteCategory($id)
    {
        $this->subcategory_id = $id;


        $this->alert('warning', 'Are you sure do want to delete?', [
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

    public function confirmedDelete()
    {
        $subcategory = ModelsSubcategory::findOrFail($this->subcategory_id);
        $subcategory->delete();
        $this->alert('success', 'Category deleted successfully');
    }

    public function render()
    {
        $categories = ModelsCategory::get();
        return view('livewire.category.subcategory', compact('categories'));
    }

}
