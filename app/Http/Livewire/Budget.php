<?php

namespace App\Http\Livewire;

use App\Models\Budget as ModelsBudget;
use App\Models\Category;
use App\Models\Operation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class Budget extends Component
{
    use WithFileUploads;
    public $creating, $deleting, $editing = false, $budget, $date;
    public $value, $description, $image, $income, $category_id, $selected_id;

    public $thresholdModal;
    public $threshold;

    protected $rules = [
        'value' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|string',
        'image' => 'nullable|file',
        'income' => 'required|boolean',
        'category_id' => 'required',
        'date' => 'required',
    ];

    public function render()
    {
        $this->budget = auth()->user()->budget;
        $this->threshold = $this->budget->threshold;
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.budget.crud', [
            'budget' => $this->budget,
            'operations' => $this->budget->allCategories(),
            'categories' => Category::all(),
        ]);
    }

    public function expense()
    {
        $this->creating = true;
        $this->date = now()->format('Y-m-d');
        $this->resetInputs();
        $this->income = false;
    }

    public function profit()
    {
        $this->creating = true;
        $this->date = now()->format('Y-m-d');
        $this->resetInputs();
        $this->income = true;
    }

    public function thresholdModal()
    {
        $this->thresholdModal = true;
    }

    public function setThreshold()
    {
        if ($this->threshold == null)
            $this->threshold = 0;
        $this->budget->threshold = $this->threshold;
        $this->budget->save();
        $this->thresholdModal = false;
    }


    public function save()
    {
        $this->validate();
        $operation = new Operation();
        if ($this->income == false)
            $this->value = $this->value * -1;
        $operation->value = $this->value;
        $operation->description = $this->description;
        $operation->income = $this->income;
        $operation->category_id = $this->category_id;
        $operation->budget_id = auth()->user()->budget->id;
        $operation->user_id = auth()->id();
        if ($this->image) {
            $image_path = $this->image->store('/public/images/posts');
            $operation->image = str_replace('public/', 'storage/', $image_path);
        }

        $operation->save();
        $budget = auth()->user()->budget;
        $budget->balance += (float)$this->value;
        $budget->save();
        session()->flash('message', 'operation created.');
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
        $operation = Operation::find($this->selected_id);
        $this->budget->balance -= $operation->value;
        $this->budget->save();
        $operation->delete();
        //TODO DELETING PHOTOS

        $this->selected_id = null;
        $this->deleting = false;
        $this->resetInputs();
    }

    private function resetInputs()
    {
        $this->value = '';
        $this->description = '';
        $this->image = null;
        $this->income = false;
        $this->category_id = 1;
    }

    // public function editing($id)
    // {
    //     $this->editing = true;
    //     $operation = Operation::find($id);
    //     $this->selected_id = $id;
    //     $this->value = $operation->value;
    //     $this->description = $operation->description;
    //     $this->income = $operation->income;
    //     $this->image = $operation->image;
    //     $this->category_id = $operation->category->id;
    // }

    // public function update()
    // {
    //     $this->validate();
    //     $operation = Operation::find($this->selected_id);
    //     if ($this->income == false)
    //         $this->value = $this->value * -1;
    //     $operation->value = $this->value;
    //     $operation->description = $this->description;
    //     $operation->income = $this->income;
    //     $operation->category_id = $this->category_id;
    //     $operation->save();

    //     session()->flash('message', 'operation created.');
    //     $this->editing = false;
    //     $this->resetInputs();
    // }
}