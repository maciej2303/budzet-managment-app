<?php

namespace App\Http\Livewire;

use App\Constants\Frequency;
use App\Constants\Months;
use App\Models\Category;
use App\Models\CyclicOperation;
use App\Models\Operation;
use App\Services\BudgetService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Budget extends Component
{
    use WithFileUploads;
    public $creating, $deleting, $editing = false, $budget, $date;
    public $name, $value, $description, $image, $income, $category_id, $selected_id;
    public $frequencies, $cyclic = false, $frequency;
    public $categories, $categoryExpenses;
    public $thresholdModal;
    public $threshold;
    public $showOperation, $operationOnModal, $operations, $expenses, $incomes;
    public $month, $year;
    public $months = Months::MONTHS;

    protected $rules = [
        'name' => 'required|string|max:200',
        'value' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|string',
        'image' => 'nullable|file',
        'income' => 'required|boolean',
        'category_id' => 'required',
        'date' => 'required',
        'frequency' => 'required',
    ];

    public function mount()
    {
        $this->frequencies = Frequency::FREQUENCIES;
        $this->frequency = Frequency::MONTH;
        $this->budget = auth()->user()->budget()->first();
        $this->categories = $this->budget->allCategories();
        $this->categoryExpenses = $this->categories;
        $this->month = today()->month;
        $this->year = today()->year;
    }

    public function render()
    {
        $this->operations = $this->budget->operations()->whereMonth('created_at', '=', $this->month)->whereYear('created_at', '=', $this->year)->orderBy('created_at')->get();
        $this->expenses = $this->operations->where('income', false)->sum('value');
        $this->incomes = $this->operations->where('income', true)->sum('value');

        $chart = BudgetService::generateBalanceChartFromOperations($this->year, $this->month, clone $this->operations, $this->budget->id);
        $this->operations = $this->operations->sortByDesc('created_at');

        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.budget.crud', [
            'budget' => $this->budget,
            'chart' => $chart,
        ]);
    }

    public function operation()
    {
        $this->creating = true;
        $this->resetInputs();
        $this->date = today()->format('Y-m-d');
        $this->income = false;
    }


    public function showOperation($id)
    {
        $this->operationOnModal = Operation::find($id);
        $this->showOperation = true;
    }

    public function thresholdModal()
    {
        $this->thresholdModal = true;
    }

    public function setThreshold()
    {
        if ($this->threshold == null)
            $this->threshold = 0;
        $this->budget->threshold = $this->threshold;
        $this->budget->save();
        $this->thresholdModal = false;
    }


    public function save()
    {
        $this->validate();
        $budgetId = $this->budget->id;
        if (!$this->cyclic || Carbon::parse($this->date) == today()) {
            $operation = new Operation();
            $operation->name = $this->name;
            if ($this->income == false)
                $this->value = $this->value * -1;
            $operation->value = $this->value;
            $operation->description = $this->description;
            $operation->income = $this->income;
            $operation->category_id = $this->category_id;
            $operation->budget_id = $budgetId;
            $operation->user_id = auth()->id();

            if ($this->image) {
                $image_path = $this->image->store('/public/images/budget/' . $budgetId);
                $operation->image = str_replace('public/', 'storage/', $image_path);
            }

            $operation->created_at =  Carbon::parse($this->date) == today() ? now() : Carbon::parse($this->date);
            $operation->save();

            //Dodanie wartości do pózniejszych pól
            $operations = $this->budget->operations()->where('created_at', '>', $operation->created_at)->get();
            foreach ($operations as $old_operation) {
                $old_operation->balance_before += $operation->value;
                $old_operation->save();
            }

            $this->budget->balance += (float)$this->value;
            $this->budget->save();
        }

        if ($this->cyclic) {
            $cyclicOperation = new CyclicOperation();
            $cyclicOperation->name = $this->name;
            $cyclicOperation->value = $this->value;
            $cyclicOperation->description = $this->description;
            $cyclicOperation->income = $this->income;
            $cyclicOperation->category_id = $this->category_id;
            $cyclicOperation->budget_id = $budgetId;
            $cyclicOperation->user_id = auth()->id();

            if ($this->image) {
                $image_path = $this->image->store('/public/images/budget/' . $budgetId);
                $cyclicOperation->image = str_replace('public/', 'storage/', $image_path);
            }

            $cyclicOperation->cyclic_date = Carbon::parse($this->date);
            $cyclicOperation->frequency = $this->frequency;

            $cyclicOperation->save();
        }
        session()->flash('message', 'operation created.');
        $this->creating = false;
        $this->resetInputs();
    }

    public function deleting($id)
    {
        $this->selected_id = $id;
        $this->deleting = true;
    }

    public function destroy()
    {
        $operation = Operation::find($this->selected_id);
        Storage::delete(str_replace('storage/', 'public/', $operation->image));
        $this->budget->balance -= $operation->value;
        $this->budget->save();
        $value = $operation->value;
        $created_at = $operation->created_at;

        $operations = $this->budget->operations()->where('created_at', '>', $created_at)->get();
        foreach ($operations as $old_operation) {
            $old_operation->balance_before -= $value;
            $old_operation->save();
        }
        $operation->delete();
        $this->selected_id = null;
        $this->deleting = false;
        $this->showOperation = false;
        $this->operationOnModal = null;
        $this->resetInputs();
    }

    private function resetInputs()
    {
        $this->name = '';
        $this->value = '';
        $this->description = '';
        $this->image = null;
        $this->income = false;
        $this->category_id = 1;
        $this->cyclic = false;
    }

    public function nextMonth()
    {
        switch ($this->month) {
            case 12:
                $this->month = 1;
                $this->year++;
                break;

            default:
                $this->month++;
                break;
        }
    }

    public function previousMonth()
    {
        switch ($this->month) {
            case 1:
                $this->month = 12;
                $this->year--;
                break;

            default:
                $this->month--;
                break;
        }
    }
}
