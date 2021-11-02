<?php

namespace App\Http\Livewire;

use App\Constants\Months;
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
    public $today;
    public $periods;
    public $period = 'prev_month';

    public function mount()
    {
        $this->budget = auth()->user()->budget;
        $this->categories = $this->budget->allCategories();
        $this->today = today();
        $this->dateFrom =  $this->today->firstOfMonth()->format('Y-m-d');
        $this->dateTo =  $this->today->lastOfMonth()->format('Y-m-d');
        $months = Months::MONTHS;
        $this->periods = [
            'current_month' => 'Bieżący miesiąc (' . $months[$this->today->month] . ')',
            'prev_month' => 'Poprzedni miesiąc (' . $months[$this->today->month - 1] . ')',
            'current_year' => 'Bieżący rok (' .  $this->today->year . ')',
            'prev_year' => 'Bieżący rok (' . ($this->today->year - 1) . ')',
            'all' => 'Cała dostępna historia',
        ];
    }

    public function render()
    {
        switch ($this->period) {
            case 'current_month':
                # code...
                break;
            case 'prev_month':
                $this->operations = $this->budget->operations()->whereMonth('created_at', ($this->today->month - 1))->whereYear('created_at', $this->today->year)->get();
                break;
            default:
                # code...
                break;
        }

        // if ($this->category != -1)
        //     $operations = $operations->whereHas('category', function ($query) {
        //         return $query->where('id', $this->category);
        //     });

        // $this->operations = $operations->get();

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
        $period = CarbonPeriod::create($this->dateFrom, $this->dateTo)->toArray();
        $days = [];
        foreach ($period as $day) {
            $day_income = 0;
            $day_expense = 0;
            $days[$day->format('d.m.Y')] = new stdClass();
            foreach ($this->operations as $operation) {
                if ($operation->created_at->format('d.m.Y') == $day->format('d.m.Y')) {
                    if ($operation->income)
                        $day_income += $operation->value;
                    else
                        $day_expense += $operation->value;
                }
            }
            $days[$day->format('d.m.Y')]->income = $day_income;
            $days[$day->format('d.m.Y')]->expense = $day_expense;
        }

        $operationsChart =  (new LineChartModel())
            ->setTitle('Wykres przychodów i wydatków');
        foreach ($days as $key => $day) {
            $operationsChart->addPoint($key, $day->amount);
        }

        $period = CarbonPeriod::create($this->dateFrom, $this->dateTo)->toArray();
        $days = [];
        $budgetValueOnStart =  $this->operations->first() != null ? $this->operations->first()->balance_before : 0;
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
