<?php

namespace App\Http\Livewire;

use App\Constants\Months;
use App\Services\BudgetService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
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
    public $xd;
    public $period = '';

    public function mount()
    {
        $this->budget = auth()->user()->budget;
        $this->categories = $this->budget->allCategories();
        $this->today = today();
        $months = Months::MONTHS;
        $this->periods = [
            'current_month' => 'Bieżący miesiąc (' . $months[$this->today->month] . ')',
            'prev_month' => 'Poprzedni miesiąc (' . $months[$this->today->month - 1] . ')',
            'current_year' => 'Bieżący rok (' .  $this->today->year . ')',
            'prev_year' => 'Bieżący rok (' . ($this->today->year - 1) . ')',
            'all' => 'Cała dostępna historia',
        ];
        $this->xd = 'current_month';
    }

    public function render()
    {
        if ($this->period == 'prev_month') {
            $month = $this->today->month - 1;
            $year = $this->today->year;
            $operations = $this->budget->operations()->whereMonth('created_at', ($month))->whereYear('created_at', $year);
        } else {
            $month = $this->today->month;
            $year = $this->today->year;
            $operations = $this->budget->operations()->whereMonth('created_at', ($month))->whereYear('created_at', $year);
        }
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
        $chart = BudgetService::generateBalanceChartFromOperations($year, $month, clone $this->operations, $this->budget->id);
        $incomeExpenseChart = BudgetService::generateIncomeAndExpenseMonthlyChart($year, $month, clone $this->operations);
        return view('livewire.reports.report',  ['chart' => $chart, 'incomeExpenseChart' => $incomeExpenseChart]);
    }
}
