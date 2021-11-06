<?php

namespace App\Services;

use App\Models\Budget;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use stdClass;
use App\Constants\Months;
use App\Models\Operation;

class ReportService
{
    public static function generateMonthlyBalanceChartFromOperations($year, $month, $operations, $budget_id): LineChartModel
    {
        $start = Carbon::createFromDate($year, $month)->startOfMonth();
        $end = Carbon::createFromDate($year, $month)->endOfMonth();

        $period = CarbonPeriod::create($start, $end)->toArray();
        $days = [];

        if ($operations->isEmpty()) {
            if ($month < today()->month) {
                $operation = Operation::where('budget_id', $budget_id)->whereMonth('created_at', '<', $month)->first();
                if ($operation != null)
                    $budgetValueOnStart = $operation->balance_before + $operation->value;
                else
                    $budgetValueOnStart = 0;
            } else {
                $budgetValueOnStart = Budget::where('id', $budget_id)->first()->balance;
            }
        } else {
            $budgetValueOnStart = $operations->first()->balance_before;
        }
        foreach ($period as $day) {
            $days[$day->format('d.m.Y')] = new stdClass();
            foreach ($operations as $key => $operation) {
                if ($operation->created_at->format('d.m.Y') == $day->format('d.m.Y')) {
                    $budgetValueOnStart += $operation->value;
                    $operations->forget($key);
                }
            }
            $days[$day->format('d.m.Y')]->amount = $budgetValueOnStart;
        }
        $chart =  (new LineChartModel())
            ->setTitle('Stan konta każdego dnia');
        foreach ($days as $key => $day) {
            $chart->addPoint($key, $day->amount);
        }

        return $chart;
    }

    public static function generateYearlyBalanceChartFromOperations($year, $month, $operations, $budget_id): LineChartModel
    {
        $start = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $end = Carbon::createFromDate($year, 1, 1)->endOfYear();

        $interval = DateInterval::createFromDateString('1 month');
        $period = CarbonPeriod::create($start, $interval, $end)->toArray();
        $monthsName = Months::MONTHS;
        $months = [];

        if ($operations->isEmpty()) {
            if ($year < today()->year) {
                $operation = Operation::where('budget_id', $budget_id)->whereYear('created_at', '<', $year)->first();
                if ($operation != null)
                    $budgetValueOnStart = $operation->balance_before + $operation->value;
                else
                    $budgetValueOnStart = 0;
            } else {
                $budgetValueOnStart = Budget::where('id', $budget_id)->first()->balance;
            }
        } else {
            $budgetValueOnStart = $operations->first()->balance_before;
        }

        foreach ($period as $monthKey => $month) {
            $months[$monthsName[$monthKey + 1]] = new stdClass();
            foreach ($operations as $key => $operation) {
                if ($operation->created_at->format('m') == $month->month) {
                    $budgetValueOnStart += $operation->value;
                    $operations->forget($key);
                }
            }
            $months[$monthsName[$monthKey + 1]]->amount = $budgetValueOnStart;
        }
        $chart =  (new LineChartModel())
            ->setTitle('Stan konta każdego miesiąca');
        foreach ($months as $key => $month) {
            $chart->addPoint($key, $month->amount);
        }

        return $chart;
    }

    public static function generateAllOfTimeBalanceChartFromOperations($operations, $budget_id): LineChartModel
    {
        $firstOperation = Operation::where('budget_id', $budget_id)->orderBy('created_at', 'asc')->first();
        if ($firstOperation == null) {
            return new LineChartModel();
        }
        $lastOperation = Operation::where('budget_id', $budget_id)->orderBy('created_at', 'desc')->first();
        $start = $firstOperation->created_at;
        $end = $lastOperation->created_at;

        $period = CarbonPeriod::create($start, $end)->toArray();
        $days = [];

        if ($operations->isEmpty()) {
            $budgetValueOnStart = 0;
        } else {
            $budgetValueOnStart = $operations->first()->balance_before;
        }
        foreach ($period as $day) {
            $days[$day->format('d.m.Y')] = new stdClass();
            foreach ($operations as $key => $operation) {
                if ($operation->created_at->format('d.m.Y') == $day->format('d.m.Y')) {
                    $budgetValueOnStart += $operation->value;
                    $operations->forget($key);
                }
            }
            $days[$day->format('d.m.Y')]->amount = $budgetValueOnStart;
        }
        $chart =  (new LineChartModel())
            ->setTitle('Stan konta każdego dnia');
        foreach ($days as $key => $day) {
            $chart->addPoint($key, $day->amount);
        }

        return $chart;
    }

    public static function generateMonthlyIncomeAndExpenseChart($year, $month, $operations): ColumnChartModel
    {
        $start = Carbon::createFromDate($year, $month)->startOfMonth();
        $end = Carbon::createFromDate($year, $month)->endOfMonth();
        $period = CarbonPeriod::create($start, $end)->toArray();
        $days = [];
        $periodArray = [];
        foreach ($period as $day) {
            $periodArray[] = $day->format('d.m.Y');
            $day_income = 0;
            $day_expense = 0;
            $days[$day->format('d.m.Y')] = new stdClass();
            foreach ($operations as $operation) {
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

        $incomeExpenseChart =  (new ColumnChartModel())->multiColumn()->setColors(['#f52314', '#14f557'])->setXAxisCategories($periodArray)
            ->setTitle('Wykres przychodów i wydatków');
        foreach ($days as $key => $day) {
            $incomeExpenseChart->addSeriesColumn('Wydatek', '1.01.2021', abs($day->expense) . ' PLN');
            $incomeExpenseChart->addSeriesColumn('Przychód', $key, $day->income . ' PLN');
        }

        return $incomeExpenseChart;
    }

    public static function generateYearlyIncomeAndExpenseChart($year, $month, $operations): ColumnChartModel
    {
        Carbon::setLocale('pl');
        $start = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $end = Carbon::createFromDate($year, 1, 1)->endOfYear();
        $interval = DateInterval::createFromDateString('1 month');
        $period = CarbonPeriod::create($start, $interval, $end)->toArray();
        $monthsName = Months::MONTHS;
        $months = [];
        foreach ($period as $key => $month) {
            $periodArray[] =  $monthsName[$key + 1];
            $day_income = 0;
            $day_expense = 0;
            $months[$month->month] = new stdClass();
            foreach ($operations as $operation) {
                if ($operation->created_at->format('m') == $month->month) {
                    if ($operation->income)
                        $day_income += $operation->value;
                    else
                        $day_expense += $operation->value;
                }
            }
            $months[$month->month]->income = $day_income;
            $months[$month->month]->expense = $day_expense;
        }

        $incomeExpenseChart =  (new ColumnChartModel())->multiColumn()->setColors(['#f52314', '#14f557'])->setXAxisCategories($periodArray)
            ->setTitle('Wykres przychodów i wydatków');
        foreach ($months as $key => $month) {
            $incomeExpenseChart->addSeriesColumn('Wydatek', $key, abs($month->expense) . ' PLN');
            $incomeExpenseChart->addSeriesColumn('Przychód', $key, $month->income . ' PLN');
        }

        return $incomeExpenseChart;
    }
}
