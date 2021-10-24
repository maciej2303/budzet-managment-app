<?php

namespace App\Services;

use App\Models\Budget;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\CarbonPeriod;
use stdClass;

class BudgetService
{
    public static function generateBalanceChartForLastThirtyDays(Budget $budget): LineChartModel
    {
        $period = CarbonPeriod::create(today()->subdays(30), today())->toArray();
        $operations = $budget->operations()->whereBetween('created_at', [today()->subdays(30), today()])->get();
        $days = [];
        $budgetValueOnStart = $operations->first()->balance_before;
        foreach ($period as $day) {

            $days[$day->format('d.m.Y')] = new stdClass();
            foreach ($operations as $operation) {
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

        return $chart;
    }
}
