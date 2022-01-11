<?php

namespace Tests\Feature;

use App\Constants\Frequency;
use App\Http\Livewire\Budget;
use App\Http\Livewire\Categories;
use App\Models\Category;
use App\Models\Operation;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

       $this->seed(TestSeeder::class);
    }


    public function test_can_create_operation()
    {
        $user = User::first();
        $this->actingAs($user);
        $category = Category::where('income', 0)->first();

        $budgetBalance = $user->budget->balance;
        Livewire::test(Budget::class)
            ->set('name', 'Wydatek test')
            ->set('income', 0)
            ->set('value', 100)
            ->set('description', 'Opis')
            ->set('category_id', $category->id)
            ->set('date', now())
            ->call('save');

        $user->refresh();
        $budgetBalanceAfterOperation = $user->budget->balance;
        $this->assertTrue(Operation::where('name', 'Wydatek test')->exists());
        $this->assertEquals((float)($budgetBalance - 100), $budgetBalanceAfterOperation);
    }

    public function test_can_remove_own_operation()
    {
        $user = User::first();
        $this->actingAs($user);
        $category = Category::where('income', 0)->first();

        Livewire::test(Budget::class)
            ->set('name', 'Wydatek test')
            ->set('income', 0)
            ->set('value', 100)
            ->set('description', 'Opis')
            ->set('category_id', $category->id)
            ->set('date', now())
            ->call('save');

        $user->refresh();
        $budgetBalance = $user->budget->balance;
        $newOperation = Operation::where('name', 'Wydatek test')->first();

        Livewire::test(Budget::class)
            ->set('selected_id', $newOperation->id)
            ->call('destroy');

        $user->refresh();
        $budgetBalanceAfterDeleting = $user->budget->balance;

        $this->assertTrue(!Operation::where('name', 'Wydatek test')->exists());
        $this->assertEquals((float)($budgetBalance + 100), $budgetBalanceAfterDeleting);
    }

    public function test_user_can_set_threshold()
    {
        $user = User::first();
        $this->actingAs($user);

        Livewire::test(Budget::class)
            ->set('threshold', 5000)
            ->call('setThreshold');

        $user->refresh();
        $this->assertEquals(5000.00, $user->budget->threshold);
    }

    public function test_cyclic_operations_working()
    {
        $user = User::first();
        $this->actingAs($user);
        $category = Category::where('income', 0)->first();

        $budgetBalance = $user->budget->balance;
        Livewire::test(Budget::class)
            ->set('name', 'Wydatek test')
            ->set('income', 0)
            ->set('value', 100)
            ->set('description', 'Opis')
            ->set('category_id', $category->id)
            ->set('date', now())
            ->set('frequency', Frequency::MONTH)
            ->set('cyclic', true)
            ->call('save');


        $this->call('GET', '/cron');
        $user->refresh();
        $budgetBalanceAfterOperation = $user->budget->balance;

        $this->assertEquals((float)$budgetBalance, $budgetBalanceAfterOperation);
    }
}
