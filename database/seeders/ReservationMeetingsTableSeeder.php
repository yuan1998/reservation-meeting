<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReservationMeetingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reservation_meetings')->delete();
        
        \DB::table('reservation_meetings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '测试',
                'room_id' => 1,
                'meeting_remark' => '会议室小程序的研发',
                'person_name' => '123',
                'person_phone' => '15686262100',
                'date' => '2023-07-18 00:00:00',
                'start' => '09:30',
                'end' => '10:00',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/e3c75781-067b-4a56-b5c4-3e7936954e99.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 09:41:47',
                'updated_at' => '2023-07-18 19:49:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '用户管理',
                'room_id' => 2,
                'meeting_remark' => '会议室小程序的研发',
                'person_name' => '123',
                'person_phone' => '13112344321',
                'date' => '2023-07-18 00:00:00',
                'start' => '09:30',
                'end' => '10:00',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/253f443b-bbf6-4bee-9f79-084242abbaf0.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 09:42:08',
                'updated_at' => '2023-07-18 19:50:14',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '用户管理',
                'room_id' => 1,
                'meeting_remark' => '会议室小程序的研发',
                'person_name' => '123',
                'person_phone' => '13112344321',
                'date' => '2023-07-18 00:00:00',
                'start' => '10:30',
                'end' => '11:00',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/b2efc4f2-1c2e-4217-b888-23a957be096c.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 09:44:25',
                'updated_at' => '2023-07-18 19:00:34',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'api会议',
                'room_id' => 1,
                'meeting_remark' => '123123',
                'person_name' => '花花',
                'person_phone' => '13112344321',
                'date' => '2023-07-18 00:00:00',
                'start' => '04:00',
                'end' => '04:30',
                'close_remark' => '结束',
                'close_image' => 'meeting_images/ad10e705-b782-4921-abeb-0a6606f843ab.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 09:56:32',
                'updated_at' => '2023-07-18 10:01:23',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'api会议',
                'room_id' => 1,
                'meeting_remark' => '123123',
                'person_name' => '花花',
                'person_phone' => '13112344321',
                'date' => '2023-07-18 00:00:00',
                'start' => '14:00',
                'end' => '14:30',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/51109061-f51d-4121-a94a-8771ed08b034.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 12:29:24',
                'updated_at' => '2023-07-18 19:47:25',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => '131123',
                'room_id' => 1,
                'meeting_remark' => '131',
                'person_name' => '131123',
                'person_phone' => '13112344321',
                'date' => '2023-07-18 00:00:00',
                'start' => '18:00',
                'end' => '18:30',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/d405dc3f-cdbc-42a3-a96a-d15da0f00243.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 14:31:22',
                'updated_at' => '2023-07-18 19:50:22',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => '超级会议',
                'room_id' => 2,
                'meeting_remark' => '123',
                'person_name' => '131',
                'person_phone' => '13112344321',
                'date' => '2023-07-18 00:00:00',
                'start' => '20:00',
                'end' => '22:00',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/638b896f-f7a5-4b7f-93d8-6222282691f2.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 19:53:30',
                'updated_at' => '2023-07-18 19:55:11',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => '131',
                'room_id' => 2,
                'meeting_remark' => '123',
                'person_name' => '131',
                'person_phone' => '13112344321',
                'date' => '2023-07-20 00:00:00',
                'start' => '15:30',
                'end' => '18:30',
                'close_remark' => NULL,
                'close_image' => 'meeting_images/e48a709d-9a52-494e-842e-26bff7567442.png',
                'user_id' => 1,
                'status' => 2,
                'created_at' => '2023-07-18 19:56:22',
                'updated_at' => '2023-07-19 10:16:40',
            ),
        ));
        
        
    }
}