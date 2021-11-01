<?php

namespace App\Http\Livewire\Budget;

use Livewire\Component;

class CategoryExpenses extends Component
{
    public $categoryExpenses, $operations, $expenses;

    public function render()
    {
        foreach ($this->categoryExpenses as $category) {
            $category->sum = 0;
            foreach ($this->operations as $operation) {
                if ($category->id == $operation->category_id && $operation->value < 0) {
                    $category->expenses += $operation->value;
                }
            }
            if ($this->expenses == 0)
                $category->percentOfAllExpenses = 0;
            else
                $category->percentOfAllExpenses = round(abs(($category->expenses / $this->expenses * 100)), 2);
        }
        $this->categoryExpenses = $this->categoryExpenses->sortBy('expenses');
        return view('livewire.budget.category-expenses');
    }
}
