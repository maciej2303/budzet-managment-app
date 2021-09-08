<?php

namespace App\Http\Controllers;

use App\Models\CyclicOperation;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CyclicOperationController extends Controller
{
    public function cron()
    {
        $cyclicOperations = CyclicOperation::where('cyclic_date', today()->format('Y-m-d'))->get();
        foreach($cyclicOperations as $cyclicOperation) {
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
        }
    }
}
