<?php

namespace Database\Seeders\Health;

use Database\Factories\Health\MedicineFactory;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicineFactory::times(10)->create();
    }
}
