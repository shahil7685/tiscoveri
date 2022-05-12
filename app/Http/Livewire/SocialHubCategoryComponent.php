<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\SocialHubCategory;

class SocialHubCategoryComponent extends Component
{
    use WithFileUploads;
    public $name, $file, $socialHubCategoryId;
    public $isOpen = 0;

    public function render()
    {
        $this->categories = SocialHubCategory::all();
        return view('livewire.social-hub-category-component');
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
        $this->file = '';
    }

    public function submit() {
        $validatedData = $this->validate([
            'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['image'] = $this->file->store('files', 'public');
        // SocialHubCategory::create($validatedData);
        SocialHubCategory::updateOrCreate(['id' => $this->socialHubCategoryId], [
            'name' => $validatedData['name'],
            'image' => $validatedData['image']

        ]);
        session()->flash('message', $this->socialHubCategoryId ? 'Social Hub Category updated.' : 'Social Hub Category added.');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id) {
        $socialHubCategory = SocialHubCategory::findOrFail($id);
        $this->socialHubCategoryId = $id;
        $this->name = $socialHubCategory->name;
        $this->image = $socialHubCategory->image;

        $this->openModal();
    }

    public function delete($id) {
        SocialHubCategory::find($id)->delete();
        session()->flash('message', 'Social Hub Category deleted.');
    }
}
