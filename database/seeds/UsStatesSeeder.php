<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //read the file using csv_to_array func
        
       $file = Storage::path('us-state.csv');
       $states_array =  $this->csv_to_array($file);
       //dd($states_array);
        for($i=0; $i < count($states_array); $i++ ){
            DB::table('us_states')->insert([
                'state' => $states_array[$i]['Abbreviation'],
                'state_name' => $states_array[$i]['Name'],
        
            ]);
        }
     
    }
    /**
     * 07/27
     * Reads in a csv file and converts it to assoc array
     * From: https://www.php.net/manual/en/function.str-getcsv.php
     * @link http://gist.github.com/385876
     */
    function csv_to_array($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}
