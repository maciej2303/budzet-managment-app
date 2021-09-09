<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function changeBudgetShow(Budget $budget): View
    {
        $user = auth()->user();
        $members = null;
        if ($user->ownedBudget && $user->ownedBudget->members()->count() > 1) {
            $members = $user->ownedBudget->members()->where('id', '!=', $user->id)->get();
        }
        return view('dashboard.budget.change-budget')->with(['budget' => $budget, 'members' => $members]);
    }

    public function changeBudget(Budget $budget, Request $request): RedirectResponse
    {
        $user = auth()->user();
        if ($user->ownedBudget && $user->ownedBudget->members()->count() == 1) {
            $ownedBudget = $user->ownedBudget;
            $user->budget_id = $budget->id;
            $user->save();
            $ownedBudget->delete();
        } else if ($user->ownedBudget && $user->ownedBudget->members()->count() > 1) {
            $ownedBudget = $user->ownedBudget;
            $user->budget_id = $budget->id;
            $user->save();
            $ownedBudget->update(['creator_id' => $request->owner_id]);
        } else {
            $user->budget_id = $budget->id;
            $user->save();
        }

        return redirect()->route('budget.index');
    }
}
