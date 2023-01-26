<?php

namespace Database\Seeders;

use App\Models\HouseholdIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HourseholdIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HouseholdIncome::create([
            'name' => 'B40',
            'discount' => '0.1',
        ]);

        HouseholdIncome::create([
            'name' => 'M40',
            'discount' => '0.05',
        ]);

        HouseholdIncome::create([
            'name' => 'T20',
            'discount' => '0',
        ]);
    }
}
