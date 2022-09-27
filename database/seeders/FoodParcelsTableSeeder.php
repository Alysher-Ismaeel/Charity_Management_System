<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FoodParcelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('food_parcels')->delete();
        
        \DB::table('food_parcels')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'size' => 'Small',
                'count' => 0,
                'cost' => 2000,
                'donate' => 0,
                'content' => 'tomato, potato, apple, pasta, banana',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 1,
                'size' => 'Medium',
                'count' => 0,
                'cost' => 3000,
                'donate' => 0,
                'content' => 'tomato, potato, apple, pasta, banana, strawberry, lemon, bread',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 1,
                'size' => 'Large',
                'count' => 0,
                'cost' => 5000,
                'donate' => 0,
                'content' => 'tomato, potato, apple, pasta, banana, strawberry, lemon, bread, chicken, meat, fish, milk, cheese',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}