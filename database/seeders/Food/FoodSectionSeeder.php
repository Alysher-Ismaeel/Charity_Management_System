<?php

namespace Database\Seeders\Food;

use Database\Factories\Food\FoodSectionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodSectionFactory::times(10)->create();
    }
}
