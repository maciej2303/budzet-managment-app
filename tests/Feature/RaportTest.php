<?php

namespace Tests\Feature;

use App\Http\Livewire\Budget;
use App\Http\Livewire\Report;
use App\Models\Category;
use App\Models\Operation;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

class RaportTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestSeeder::class);
    }

    public function test_raport_page_contains_livewire_component()

    {
        $user = User::first();
        $this->actingAs($user);
        $this->get('/reports')
            ->assertSeeLivewire('report');
    }
    public function test_raport_page_contains_fields()
    {
        $user = User::first();
        $this->actingAs($user);

        Livewire::test(Report::class)
            ->assertSee('Saldo konta')
            ->assertSee('Przychód');
    }
}
