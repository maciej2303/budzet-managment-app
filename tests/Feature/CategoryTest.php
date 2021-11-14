<?php

namespace Tests\Feature;

use App\Http\Livewire\Categories;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestSeeder::class);
    }


    public function test_can_create_post()
    {
        $this->actingAs(User::first());

        Livewire::test(Categories::class)
            ->set('name', 'Przekąski')
            ->set('income', 0)
            ->set('icon', UploadedFile::fake()->image('avatar.jpg'))
            ->call('save');

        $this->assertTrue(Category::where('name', 'Przękaski')->exists());
    }

    public function test_can_remove_category_if_it_is_empty()
    {
        $this->actingAs(User::first());

        Livewire::test(Categories::class)
            ->set('name', 'Przekąski')
            ->set('income', 0)
            ->set('icon', UploadedFile::fake()->image('avatar.jpg'))
            ->call('save');

        $newCategory = Category::where('name', 'Przękaski')->first();

        Livewire::test(Categories::class)
            ->call('destroy', $newCategory->id);

        $this->assertTrue(!Category::where('name', 'Przękaski')->exists());
    }

    public function test_cannot_remove_category_if_it_is_not_empty()
    {
        $this->actingAs(User::first());

        $categoryWithOperations =  Category::whereHas('operations')->first();

        Livewire::test(Categories::class)
            ->call('destroy', $categoryWithOperations->id);

        $this->assertTrue(Category::where('id', $categoryWithOperations->id)->exists());
    }
}
