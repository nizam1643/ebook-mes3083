<?php

namespace Database\Seeders;

use App\Models\AuthorPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AuthorPackage::create([
            'name' => 'Basic',
            'sub_name' => 'Trial Package',
            'price' => '30',
            'task' => '3',
        ]);

        AuthorPackage::create([
            'name' => 'Moderate',
            'sub_name' => 'Beginner Package',
            'price' => '50',
            'task' => '7',
        ]);

        AuthorPackage::create([
            'name' => 'Super',
            'sub_name' => 'Advanced Package',
            'price' => '100',
            'task' => '20',
        ]);
        
    }
}
