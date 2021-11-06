<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Constants\Months;
use App\Services\BudgetService;
use App\Services\ReportService;

class Report extends Component
{
    public $budget;
    public $categories, $category = -1;
    public $dateFrom, $dateTo;
    public $search;
    public $operations, $expenses, $incomes;
    public $today;
    public $periods, $period = 'current_month';
    public function mount()
    {
        $this->budget = auth()->user()->budget()->with('operations', 'members')->first();
        $this->categories = $this->budget->allCategories();
        $this->dateFrom = today()->firstOfMonth()->format('Y-m-d');
        $this->dateTo = today()->lastOfMonth()->format('Y-m-d');
        $this->today = today();
        $months = Months::MONTHS;
        $this->periods = [
            'current_month' => 'Bieżący miesiąc (' . $months[$this->today->month] . ')',
            'prev_month' => 'Poprzedni miesiąc (' . $months[$this->today->month - 1] . ')',
            'current_year' => 'Bieżący rok (' .  $this->today->year . ')',
            'prev_year' => 'Poprzedni rok (' . ($this->today->year - 1) . ')',
            'all' => 'Cała dostępna historia',
        ];
    }

    public function render()
    {
        $operations = $this->budget->operations();
        if ($this->category != -1)
            $operations = $operations->whereHas('category', function ($query) {
                return $query->where('id', $this->category);
            });

        if ($this->period == 'prev_month') {
            $month = $this->today->month - 1;
            $year = $this->today->year;
            $operations = $operations->whereMonth('created_at', ($month))->whereYear('created_at', $year)->get();
            $chart = ReportService::generateMonthlyBalanceChartFromOperations($year, $month, clone $operations, $this->budget->id);
            $incomeExpenseChart = ReportService::generateMonthlyIncomeAndExpenseChart($year, $month, clone $operations);
        } else if ($this->period == 'current_year') {
            $month = $this->today->month;
            $year = $this->today->year;
            $operations = $operations->whereYear('created_at', $year)->get();
            $chart = ReportService::generateYearlyBalanceChartFromOperations($year, $month, clone $operations, $this->budget->id);
            $incomeExpenseChart = ReportService::generateYearlyIncomeAndExpenseChart($year, $month, clone $operations);
        } else if ($this->period == 'prev_year') {
            $month = $this->today->month;
            $year = $this->today->year - 1;
            $operations = $operations->whereYear('created_at', $year)->get();
            $chart = ReportService::generateYearlyBalanceChartFromOperations($year, $month, clone $operations, $this->budget->id);
            $incomeExpenseChart = ReportService::generateYearlyIncomeAndExpenseChart($year, $month, clone $operations);
        } else if ($this->period == 'all') {
            $month = $this->today->month;
            $year = $this->today->year;
            $operations = $operations->get();
            $chart = ReportService::generateAllOfTimeBalanceChartFromOperations(clone $operations, $this->budget->id);
            $incomeExpenseChart = ReportService::generateYearlyIncomeAndExpenseChart($year, $month, clone $operations);
        } else {
            $month = $this->today->month;
            $year = $this->today->year;
            $operations = $operations->whereMonth('created_at', ($month))->whereYear('created_at', $year)->get();
            $chart = ReportService::generateMonthlyBalanceChartFromOperations($year, $month, clone $operations, $this->budget->id);
            $incomeExpenseChart = ReportService::generateMonthlyIncomeAndExpenseChart($year, $month, clone $operations);
        }

        $this->operations = $operations;

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
        return view('livewire.reports.report',  ['chart' => $chart, 'incomeExpenseChart' => $incomeExpenseChart]);
    }
}
