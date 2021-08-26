<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function changeBudgetShow(Budget $budget)
    {
        return view('dashboard.budget.change-budget')->with('budget', $budget);
    }
}
