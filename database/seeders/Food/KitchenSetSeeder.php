<?php

namespace Database\Seeders\Food;

use Database\Factories\Food\kitchenSetFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KitchenSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        kitchenSetFactory::times(10)->create();
    }
}
