<?php

namespace App\Http\Livewire;

use App\Models\CyclicOperation;
use Livewire\Component;
use Storage;

class CyclicOperations extends Component
{
    public $deleting;
    public $selected_id;
    public $budget;

    public function render()
    {
        $this->budget = auth()->user()->budget;
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.cyclic-operations.index', [
            'budget' => $this->budget,
        ]);
    }

    public function deleting($id)
    {
        $this->selected_id = $id;
        $this->deleting = true;
    }

    public function destroy()
    {
        $operation = CyclicOperation::find($this->selected_id);
        Storage::delete(str_replace('storage/', 'public/', $operation->image));
        $operation->delete();

        $this->selected_id = null;
        $this->deleting = false;
    }
}
