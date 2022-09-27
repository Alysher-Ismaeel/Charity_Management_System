<?php

namespace Database\Seeders\Health;
use Database\Factories\Health\PatientFactory;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatientFactory::times(10)->create();
    }
}
