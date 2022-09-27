<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
         \DB::table('categories')->insert(array(
            0=>
            array(
                'id'=>1,
                'name'=>'Health',
                'created_at'=>null,
                'updated_at'=>null,
            ),
             1=>
                 array(
                     'id'=>2,
                     'name'=>'Food',
                     'created_at'=>null,
                     'updated_at'=>null,
                 ),
             2=>
                 array(
                     'id'=>3,
                     'name'=>'Education',
                     'created_at'=>null,
                     'updated_at'=>null,
                 ),
         ));
        
        
    }
}
