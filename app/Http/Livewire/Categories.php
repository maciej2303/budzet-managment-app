<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\ComponentConcerns\ValidatesInput;
use Livewire\WithFileUploads;
use Storage;

class Categories extends Component
{
    use WithFileUploads;
    public $creating, $deleting, $editing = false;
    public $name, $icon, $selected_id;

    protected $rules = [
        'name' => 'required|max:300',
        'icon' => 'required|file',
    ];

    public function render()
    {
        return view('livewire.categories.crud', [
            'defaultCategories' => Category::default()->get(),
            'data' => auth()->user()->budget->categories()->paginate(20),
        ]);
    }

    public function creating()
    {
        $this->creating = true;
        $this->resetInputs();
    }

    public function save()
    {
        $this->validate();
        $category = new Category();
        $category->name = $this->name;
        $category->user_id = auth()->id();
        $category->budget_id = auth()->user()->budget->id;
        if ($this->icon) {
            $image_path = $this->icon->store('/public/images/categories');
            $category->icon  = str_replace('public/', 'storage/', $image_path);
        }
        $category->save();
        session()->flash('message', 'category created.');
        $this->creating = false;
        $this->resetInputs();
    }

    public function deleting($id)
    {
        $this->selected_id = $id;
        $this->deleting = true;
    }

    public function destroy()
    {
        $category = Category::find($this->selected_id);
        Storage::delete(str_replace('storage/', 'public/', $category->icon));
        $category->delete();
        $this->selected_id = null;
        $this->deleting = false;
        $this->resetInputs();
    }

    public function editing($id)
    {
        $this->resetInputs();
        $this->editing = true;
        $category = Category::find($id);
        $this->selected_id = $id;
        $this->name = $category->name;
        $this->icon = null;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:3',
            'icon' => 'nullable|image',
        ]);
        $category = Category::find($this->selected_id);
        $category->name = $this->name;
        if ($this->icon) {
            Storage::delete(str_replace('storage/', 'public/', $category->icon));
            $image_path = $this->icon->store('/public/images/categories');
            $category->icon  = str_replace('public/', 'storage/', $image_path);
        }

        $category->save();
        session()->flash('message', 'category created.');
        $this->editing = false;
        $this->resetInputs();
    }

    private function resetInputs()
    {
        $this->name = '';
        $this->icon = '';
        $this->resetErrorBag();
        $this->selected_id = null;
    }
}
