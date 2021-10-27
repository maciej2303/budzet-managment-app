<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Operation;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use stdClass;

class BudgetService
{
    public static function generateBalanceChartFromOperations($year, $month, $operations, $budget_id): LineChartModel
    {
        $start = Carbon::createFromDate($year, $month)->startOfMonth();
        $end = Carbon::createFromDate($year, $month)->endOfMonth();
        if ($month == today()->month) {
            $end = today();
        }

        $period = CarbonPeriod::create($start, $end)->toArray();
        $days = [];
        if (!empty($operations)) {
            $operation = $month < today()->month ? Operation::where('budget_id', $budget_id)->whereMonth('created_at', '<', $month)->first() : null;
            if ($operation != null)
                $budgetValueOnStart = $operation->balance_before + $operation->value;
            else
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
}
