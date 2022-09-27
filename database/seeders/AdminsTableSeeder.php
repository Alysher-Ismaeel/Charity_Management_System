<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admins')->delete();
        
        \DB::table('admins')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$2ohksMD6HzkhjgMNQNud7O2DMkPbLpscS8YxsWzb4ExhVi/ObzzkO',
                'remember_token' => NULL,
                'created_at' => '2022-08-11 08:26:10',
                'updated_at' => '2022-08-11 08:26:10',
            ),
        ));
        
        
    }
}