<?php

namespace Database\Seeders\Health;

use Database\Factories\Health\MedicalToolFactory;
use Illuminate\Database\Seeder;

class MedicalToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicalToolFactory::times(10)->create();
    }
}
