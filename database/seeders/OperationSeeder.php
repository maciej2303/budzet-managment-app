<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balance = 0;
        for ($j = 50; $j > 0; $j--) {
            for ($i = 0; $i < 10; $i++) {

                $value = (rand(0, 1000) - 500);
                $income = $value > 0 ? 1 : 0;
                DB::table('operations')->insert([
                    'value' => $value,
                    'balance_before' => $balance,
                    'description' => 'test',
                    'income' => $income,
                    'user_id' => '1',
                    'category_id' => rand(1, Category::get()->count()),
                    'budget_id' => '1',
                    'created_at' => now()->subDay($j),
                    'updated_at' => now()->subDay($j),
                ]);

                $balance += $value;
            }
        }
        $budget = Budget::first();
        $budget->balance = $balance;
        $budget->save();
    }
}
