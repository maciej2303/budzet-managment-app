<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Report extends Component
{
    public $budget;
    public $categories, $category = -1;
    public $dateFrom, $dateTo;
    public $search;
    public $operations;

    public function mount()
    {
        $this->budget = auth()->user()->budget()->with('operations', 'members')->first();
        $this->categories = $this->budget->allCategories();
        $this->dateFrom = today()->firstOfMonth()->format('d-m-Y');
        $this->dateTo = today()->lastOfMonth()->format('d-m-Y');
    }

    public function render()
    {
        $this->operations = $this->budget->operations()->where('created_at', [$this->dateFrom, $this->dateTo])->get();
        return view('livewire.reports.report');
    }
}
