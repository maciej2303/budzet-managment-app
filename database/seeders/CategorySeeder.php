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
        $categories = ['Rodzina', 'Zdrowie','Transport','Artykuły spożywcze','Trening','Prezenty','Edukacja','Dom','Elektronika', 'Rachunki','Wypoczynek', 'Inne'];
        foreach ($categories as $category){
            DB::table('categories')->insert([
                'name' => $category,
                'default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
