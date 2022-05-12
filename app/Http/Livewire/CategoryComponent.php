<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Category;

class CategoryComponent extends Component
{
    use WithFileUploads;
    public $name, $description, $file, $categoryId, $parentId, $isUKOnly;
    public $isOpen = 0;

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.category-component');
    }

    public function create() {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal() {
        $this->isOpen = true;
    }

    public function closeModal() {
        $this->isOpen = false;
    }

    private function resetInputFields() {
        $this->name = '';
        $this->description = '';
        $this->file = '';
        $this->isUKOnly = false;
        $this->parentId = -1;
    }

    public function submit() {
        $validatedData = $this->validate([
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'required',
            'is_uk_only' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['image'] = $this->file->store('files', 'public');
        // SocialHubCategory::create($validatedData);
        Category::updateOrCreate(['id' => $this->categoryId], [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'parent_id' => $validatedData['parent_id'],
            'is_uk_only' => $validatedData['is_uk_only']
        ]);
        session()->flash('message', $this->categoryId ? 'Category updated.' : 'Category added.');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        $this->id = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->image = $category->image;
        $this->parentId = $category->parent_id;
        $this->isUKOnly = $category->is_uk_only;

        $this->openModal();
    }

    public function delete($id) {
        Category::find($id)->delete();
        session()->flash('message', 'Category deleted.');
    }
}
