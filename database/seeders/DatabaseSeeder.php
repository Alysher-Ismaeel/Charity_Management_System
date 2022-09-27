<?php

namespace Database\Seeders;
use Database\Seeders\Education\GuaranteeSeeder;
use Database\Seeders\Food\FoodSectionSeeder;
use Database\Seeders\Food\KitchenSetSeeder;
use Database\Seeders\Health\MedicalToolSeeder;
use Database\Seeders\Health\MedicineSeeder;
use Database\Seeders\Health\PatientSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminsTableSeeder::class,
            CategoriesTableSeeder::class,
            CharityBoxesTableSeeder::class,
            UsersSeeder::class,
            PatientSeeder::class,
            MedicineSeeder::class,
            MedicalToolSeeder::class,
            FoodSectionSeeder::class,
            KitchenSetSeeder::class,
            GuaranteeSeeder::class]);
        $this->call(StationeriesTableSeeder::class);
        $this->call(FoodParcelsTableSeeder::class);
    }
}
