<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\CarbonPeriod;
use Livewire\Component;
use stdClass;

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

        // ! Ile przychodu kazdego dnia
        //TODO: do refaktoru
        // $period = CarbonPeriod::create($this->dateFrom, $this->dateTo)->toArray();
        // $days = [];
        // foreach ($period as $day) {
        //     $day_value = 0;
        //     $days[$day->format('d.m.Y')] = new stdClass();
        //     foreach ($this->operations as $operation) {
        //         if ($operation->created_at->format('d.m.Y') == $day->format('d.m.Y')) {
        //             $day_value += $operation->value;
        //         }
        //     }
        //     $days[$day->format('d.m.Y')]->amount = $day_value;
        // }

        // $chart =  (new LineChartModel())
        //     ->setTitle('Expenses by Type');
        // foreach ($days as $key => $day) {
        //     $chart->addPoint($key, $day->amount);
        // }

        $period = CarbonPeriod::create($this->dateFrom, $this->dateTo)->toArray();
        $days = [];
        $budgetValueOnStart = $this->operations->first()->balance_before;
        foreach ($period as $day) {

            $days[$day->format('d.m.Y')] = new stdClass();
            foreach ($this->operations as $operation) {
                if ($operation->created_at->format('d.m.Y') == $day->format('d.m.Y')) {
                    $budgetValueOnStart += $operation->value;
                }
            }
            $days[$day->format('d.m.Y')]->amount = $budgetValueOnStart;
        }
        $chart =  (new LineChartModel())
            ->setTitle('Stan konta każdego dnia');
        foreach ($days as $key => $day) {
            $chart->addPoint($key, $day->amount);
        }

        return view('livewire.reports.report',  ['chart' => $chart]);
    }
}
