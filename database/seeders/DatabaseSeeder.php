<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Saurabh',
            'email' => 'saurabh@yopmail.com',
            'password' => bcrypt('Qwerty@1234')
        ]);

        Account::create([
            'user_id' => $user->id,
            'available_balance' => 0,
            'locked_balance' => 0
        ]);

        $this->call(ProductSeeder::class);
    }
}
