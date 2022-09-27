<?php

namespace Database\Seeders\Education;

use Database\Factories\Education\guaranteeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuaranteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        guaranteeFactory::times(10)->create();
    }
}
