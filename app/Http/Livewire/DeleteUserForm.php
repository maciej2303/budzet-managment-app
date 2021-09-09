<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Livewire\Component;

class DeleteUserForm extends Component
{
    /**
     * Indicates if user deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingUserDeletion = false;

    /**
     * The user's current password.
     *
     * @var string
     */
    public $password = '';

    public $owner_id = '', $members = null;
    /**
     * Confirm that the user would like to delete their account.
     *
     * @return void
     */
    public function confirmUserDeletion()
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-delete-user');

        $this->confirmingUserDeletion = true;
    }

    /**
     * Delete the current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Jetstream\Contracts\DeletesUsers  $deleter
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $auth
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request, DeletesUsers $deleter, StatefulGuard $auth)
    {
        $this->resetErrorBag();

        if (!Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('Hasło się nie zgadza.')],
            ]);
        }

        $user = auth()->user();
        if ($user->ownedBudget && $user->ownedBudget->members()->count() == 1) {
            $ownedBudget = $user->ownedBudget;
            $user->update(['budget_id' => null]);
            $user->delete();
            $ownedBudget->delete();
        } else if ($user->ownedBudget && $user->ownedBudget->members()->count() > 1) {
            $ownedBudget = $user->ownedBudget;
            $user->update(['budget_id' => null]);
            $user->delete();
            $ownedBudget->update(['creator_id' => $this->owner_id]);
        } else {
            $user->update(['budget_id' => null]);
            $user->delete();
        }

        $deleter->delete(Auth::user()->fresh());

        $auth->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function mount()
    {
        $user = auth()->user();
        if ($user->ownedBudget && $user->ownedBudget->members()->count() > 1) {
            $this->members = $user->ownedBudget->members()->where('id', '!=', $user->id)->get();
            $this->owner_id = $this->members->first()->id;
        }
    }
    public function render()
    {
        $budget = auth()->user()->budget;
        return view('profile.delete-user-form', compact(['budget']));
    }
}
