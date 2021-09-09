<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Report extends Component
{
    public $budget;
    public $categories, $category = -1;
    public $dateFrom, $dateTo;
    public $search;
    public $operations, $expenses, $incomes;

    public function mount()
    {
        $this->budget = auth()->user()->budget()->with('operations', 'members')->first();
        $this->categories = $this->budget->allCategories();
        $this->dateFrom = today()->firstOfMonth()->format('Y-m-d');
        $this->dateTo = today()->lastOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $this->operations = $this->budget->operations()->whereBetween('created_at', [$this->dateFrom, $this->dateTo])->get();
        $this->expenses = $this->operations->where('income', false)->sum('value');
        $this->incomes = $this->operations->where('income', true)->sum('value');
        return view('livewire.reports.report');
    }
}
