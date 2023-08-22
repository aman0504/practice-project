<?php

namespace App\Http\Livewire\Category;

use App\Models\Category as ModelsCategory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Category extends Component
{
    use LivewireAlert;
    public $title, $description, $categories_id, $title1;
    public $categories, $category_id;
    protected $listeners = ['confirmedDelete'];
    // composer require jantinnerezo/livewire-alert:^2.1  .... use this package for sweetalert


    public function mount()
    {
        $this->categories = ModelsCategory::get();
    }

    public function rules()
    {
        return [
            'title' => 'required|unique:categories,title',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The category title is required.',
            'title.unique' => 'Category already exists.',
        ];
    }

    public function resetInput()
    {
        $this->title = '';
        $this->description = '';
    }

    public function store()
    {
        $this->validate();

        $category = new ModelsCategory;
        $category->title = $this->title;
        $category->description = $this->description;
        $category->save();
        $this->alert('success', 'Category saved successfully.');
        $this->resetInput();
    }

    public function editCategory($id)
    {
        $category = ModelsCategory::findOrFail($this->category_id);
        $this->title = $category->title;
        $this->description = $category->description;
        $this->showModelCategory();
    }


    public function deleteCategory($id)
    {
        $this->category_id = $id;


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
        $category = ModelsCategory::findOrFail($this->category_id);
        $category->delete();
        $this->alert('success', 'Category deleted successfully');
    }

    public function showModelCategory()
    {
        $this->emit('showModal');
    }

    public function closeModal()
    {
        $this->emit('closeModal');
    }



    public function render()
    {

        return view('livewire.category.category');
    }
}
