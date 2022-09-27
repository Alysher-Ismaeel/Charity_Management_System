<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StationeriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stationeries')->delete();
        
        \DB::table('stationeries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 3,
                'name' => 'Primary Class Stationery',
                'count' => 0,
                'cost' => 1500,
                'size' => 'small',
                'donate' => 0,
                'content' => '2x pencil,
3x Books,
3x Notebooks',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 3,
                'name' => 'High School Stationery',
                'count' => 0,
                'cost' => 2000,
                'size' => 'medium',
                'donate' => 0,
                'content' => '2x Pencil,
4x Pen,
6x Book,
6x Notebook,
1x Role,
1x compass,',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 3,
                'name' => 'Full Option Stationery',
                'count' => 0,
                'cost' => 3000,
                'size' => 'big',
                'donate' => 0,
                'content' => 'All Education Tools',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}