<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['Rodzina', '/images/category-icons/family-icon.png'],
            ['Zdrowie', '/images/category-icons/health-icon.png'],
            ['Transport', '/images/category-icons/transport-icon.png'],
            ['Trening', '/images/category-icons/sport-icon.png'],
            ['Prezenty', '/images/category-icons/gift-icon.png'],
            ['Edukacja', '/images/category-icons/education-icon.png'],
            ['Dom', '/images/category-icons/house-icon.png'],
            ['Elektronika', '/images/category-icons/electronic-icon.png'],
            ['Rachunki', '/images/category-icons/billings-icon.png'],
            ['Wypoczynek', '/images/category-icons/rest-icon.png'],
            ['Inne', '/images/category-icons/others-icon.png'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'icon' => $category[1],
                'default' => 1,
                'income' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $income_categories = [
            ['Pensja', '/images/category-icons/salary-icon.png'],
            ['Oszczędności', '/images/category-icons/savings-icon.png'],
            ['Handel', '/images/category-icons/trade-icon.png'],
        ];

        foreach ($income_categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'icon' => $category[1],
                'default' => 1,
                'income' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
