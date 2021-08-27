<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@mirit.pl',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('budgets')->insert([
            'creator_id' => '1',
            'balance' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user = User::first();
        $user->budget_id = 1;
        $user->save();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin2@mirit.pl',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('budgets')->insert([
            'creator_id' => '2',
            'balance' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user2 = User::find(2);
        $user2->budget_id = 2;
        $user2->save();
    }
}
