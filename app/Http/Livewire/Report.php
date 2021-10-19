<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
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
        $operations = $this->budget->operations()->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);

        if ($this->category != -1)
            $operations = $operations->whereHas('category', function ($query) {
                return $query->where('id', $this->category);
            });

        $this->operations = $operations->get();

        foreach ($this->categories as $category) {
            $category->sum = 0;
            foreach ($this->operations as $operation) {
                if ($category->id == $operation->category_id) {
                    $category->sum += $operation->value;
                }
            }
        }


        $this->expenses = $this->operations->where('income', false)->sum('value');
        $this->incomes = $this->operations->where('income', true)->sum('value');
        $this->dispatchBrowserEvent('contentChanged');
        $chart =  (new ColumnChartModel())
            ->setTitle('Expenses by Type')
            ->addColumn('Food', 100, '#f6ad55')
            ->addColumn('Shopping', 200, '#fc8181')
            ->addColumn('Travel', 300, '#90cdf4');

        return view('livewire.reports.report',  ['chart' => $chart]);
    }
}
