<?php

namespace App\Http\Controllers;

use App\Constants\Frequency;
use App\Models\CyclicOperation;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CyclicOperationController extends Controller
{
    public function cron()
    {
        $cyclicOperations = CyclicOperation::where('cyclic_date', today()->format('Y-m-d'))->get();
        foreach ($cyclicOperations as $cyclicOperation) {
            $operation = new Operation();
            $operation->value = $cyclicOperation->value;
            $operation->description = $cyclicOperation->description;
            $operation->income = $cyclicOperation->income;
            $operation->category_id = $cyclicOperation->category_id;
            $operation->budget_id = $cyclicOperation->budget_id;
            $operation->user_id = $cyclicOperation->user_id;
            $operation->image = $cyclicOperation->image;
            $operation->created_at =  Carbon::parse($cyclicOperation->date);
            $operation->save();

            switch ($cyclicOperation->frequency) {
                case Frequency::DAY:
                    $cyclicOperation->cyclic_date = Carbon::parse($cyclicOperation->cyclic_date)->addDay();
                    break;

                case Frequency::WEEK:
                    $cyclicOperation->cyclic_date = Carbon::parse($cyclicOperation->cyclic_date)->addWeek();
                    break;

                case Frequency::QUARTER:
                    $cyclicOperation->cyclic_date = Carbon::parse($cyclicOperation->cyclic_date)->addQuarterNoOverflow();
                    break;

                case Frequency::YEAR:
                    $cyclicOperation->cyclic_date = Carbon::parse($cyclicOperation->cyclic_date)->addYearNoOverflow();
                    break;

                default:
                    $cyclicOperation->cyclic_date = Carbon::parse($cyclicOperation->cyclic_date)->addMonthNoOverflow();
                    break;
            }

            $cyclicOperation->save();
        }
    }
}
