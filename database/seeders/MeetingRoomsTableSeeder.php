<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MeetingRoomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('meeting_rooms')->delete();
        
        \DB::table('meeting_rooms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '超级小熊猫',
                'capacity' => 10,
                'tools' => '["投影仪", "白板", "音箱", "话筒"]',
                'open_time' => 0,
                'close_time' => 47,
                'enable' => 1,
                'need_audit' => 0,
                'order' => 2,
                'remark' => '超级小熊猫在哪里',
                'created_at' => '2023-07-17 14:04:20',
                'updated_at' => '2023-07-17 14:05:14',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '超级小恐龙',
                'capacity' => 10,
                'tools' => '["投影仪", "白板", "音箱", "话筒"]',
                'open_time' => 0,
                'close_time' => 47,
                'enable' => 1,
                'need_audit' => 0,
                'order' => 1,
                'remark' => '超级小恐龙',
                'created_at' => '2023-07-17 14:05:10',
                'updated_at' => '2023-07-17 14:05:14',
            ),
        ));
        
        
    }
}