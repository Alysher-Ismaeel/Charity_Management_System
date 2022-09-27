<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CharityBoxesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('charity_boxes')->delete();
        
        \DB::table('charity_boxes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'money' => 0,
                'password' => '$2y$10$uUKvG4KpEs.QC1FItnbzG.zIYy1wFnBhnq0/kCCrAZSCbxT.brcgq',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}