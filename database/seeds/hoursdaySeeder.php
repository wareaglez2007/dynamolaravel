<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class hoursdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $weekdays = [
            "1" => "Sunday",
            "2" => "Monday",
            "3" => "Tuesday",
            "4" => "Wednesday",
            "5" => "Thursday",
            "6" => "Friday",
            "7" => "Saturday"
        ];
        $json_weekdays = json_encode($weekdays);

        $hours =
            [
                "00:00 AM",
                "00:30 AM",
                "01:00 AM",
                "01:30 AM",
                "02:00 AM",
                "02:30 AM",
                "03:00 AM",
                "03:30 AM",
                "04:00 AM",
                "04:30 AM",
                "05:00 AM",
                "05:30 AM",
                "06:00 AM",
                "06:30 AM",
                "07:00 AM",
                "07:30 AM",
                "08:00 AM",
                "08:30 AM",
                "09:00 AM",
                "09:30 AM",
                "10:00 AM",
                "10:30 AM",
                "11:00 AM",
                "11:30 AM",
                "12:00 PM",
                "12:30 PM",
                "01:00 PM",
                "01:30 PM",
                "02:00 PM",
                "02:30 PM",
                "03:00 PM",
                "03:30 PM",
                "04:00 PM",
                "04:30 PM",
                "05:00 PM",
                "05:30 PM",
                "06:00 PM",
                "06:30 PM",
                "07:00 PM",
                "07:30 PM",
                "08:00 PM",
                "08:30 PM",
                "09:00 PM",
                "09:30 PM",
                "10:00 PM",
                "10:30 PM",
                "11:00 PM",
                "11:30 PM"



            ];
        $json_hours = json_encode($hours);



        DB::table('hoursdays')->insert([
            'week_days' => $json_weekdays,
            'hours' => $json_hours,

        ]);
    }
}
