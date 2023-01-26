<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Said Nadim',
            'email' => 'nizam4din@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
