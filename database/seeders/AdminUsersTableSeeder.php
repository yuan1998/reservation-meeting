<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$cIVrceINhmLntGjZdlMEQ.WhMBVUZXiLnSv30.pFXMBZAUgTr/oxa',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-07-17 09:05:18',
                'updated_at' => '2023-07-17 09:05:18',
            ),
        ));
        
        
    }
}