<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PersonalAccessTokensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('personal_access_tokens')->delete();
        
        \DB::table('personal_access_tokens')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tokenable_type' => 'App\\Models\\User',
                'tokenable_id' => 1,
                'name' => 'token',
                'token' => 'a12055988d877d4fa476081c3291fd4424e8658330577d9a1107a44bb7046d1b',
                'abilities' => '["*"]',
                'last_used_at' => '2023-07-19 12:51:47',
                'expires_at' => NULL,
                'created_at' => '2023-07-17 15:29:49',
                'updated_at' => '2023-07-19 12:51:47',
            ),
        ));
        
        
    }
}