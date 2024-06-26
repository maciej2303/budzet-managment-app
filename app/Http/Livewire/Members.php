<?php

namespace App\Http\Livewire;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Members extends Component
{
    public $creating, $deleting, $editing = false;
    public $selected_id, $invitationLink;

    public function render()
    {
        return view('livewire.members.crud', [
            'data' => auth()->user()->budget->members()->paginate(20),
        ]);
    }

    public function creating()
    {
        $this->creating = true;
        $this->invitationLink = URL::signedRoute('register.budget', ['budget' => auth()->user()->budget->id], now()->addHours(24));
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
        $user = User::find($this->selected_id);
        $budget = Budget::create(['creator_id' => $user->id]);
        $user->budget_id = $budget->id;
        $user->save();
        $this->deleting = false;
        $this->resetInputs();
    }

    private function resetInputs()
    {
        $this->resetErrorBag();
        $this->selected_id = null;
    }
}
