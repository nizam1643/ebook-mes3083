<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Nizamuddin Nadim',
            'email' => 'nizamx4din@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'author',
        ]);
    }
}
