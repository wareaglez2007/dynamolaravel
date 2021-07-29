<?php

namespace App\Http\Controllers;

use App\hoursdays;
use App\location_hours;
use App\locations;
use App\locationContacts;
use App\us_states;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationData;
use Auth;


use function GuzzleHttp\json_decode;

class LocationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations_data = locations::orderBy('id', 'ASC')->with('location_hours')->with('location_contacts')->get();
        $daysData = hoursdays::getDays();
        $states = us_states::getStates();
        foreach ($daysData as $days) {
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach ($hoursData as $hours) {
            $hours = json_decode($hours->hours, true);
        }

        return view('admin.modules.general', [
            'mod_name' => 'Business Information Manager',
            'locations' => $locations_data,
            'days' => $weekdays,
            'hours' => $hours,
            'states' => $states
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, locations $locations, location_hours $location_hours)
    {
        //Save data into locations
        $response_messages = [];
        // var_dump($request->days);


        //Data Validation

        $validatedData = $request->validate([
            'location_name' => ['required', 'unique:locations'],
            'addr1' => ['required'],
            'postal' => 'required|regex:/^[0-9]{3,7}$/',
            'city' => ['required'],
            'state' => ['required'],

        ]);


        $count = $locations->get()->count();
        $locations->location_name = $request->location_name;
        $locations->street = $request->addr1;
        $locations->street2 = $request->addr2;
        $locations->city = $request->city;
        $locations->state = $request->state;
        $locations->postal = $request->postal;
        $locations->added_by = Auth::user()->id;
        $locations->save();
        if (is_countable($request->rowcount) && count($request->rowcount) > 0) {
            foreach ($request->rowcount as $i) {

                $location_hours = new location_hours();
                $location_hours->days = $request->days['day_' . $i];
                $location_hours->hours_from = $request->days['hours_from_' . $i];
                $location_hours->hours_to = $request->days['hours_to_' . $i];
                $location_hours->locations_id = $locations->id;
                $locations->location_hours()->save($location_hours);
            }
        }



        $response_messages['success'] = $request->location_name . " has been added.";
        $response_messages['locationid'] = $locations->id;


        $states = us_states::getStates();
        $locations_data = $locations->with('location_hours')->orderBy('id', 'ASC')->get();
        $daysData = hoursdays::getDays();
        foreach ($daysData as $days) {
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach ($hoursData as $hours) {
            $hours = json_decode($hours->hours, true);
        }

        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Business Information Manager',
                'request' => $request,
                'view' => view('admin.layouts.partials.Mods.Locations.locations')->with([
                    "locations" => $locations_data,
                    'days' => $weekdays,
                    'hours' => $hours,
                    'states' => $states
                ])->render()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, locations $locations)
    {
        $response_messages = [];
        //Data Validation

        $validatedData = $request->validate([
            'location_name' => ['required'],
            'addr1' => ['required'],
            'postal' => 'required|regex:/^[0-9]{3,7}$/',
            'city' => ['required'],
            'state' => ['required'],

        ]);

        //Check to see if id exists in db
        $check_id = $locations->find($request->id)->count();
        $location_id = $locations->find($request->id);
        // location_name: bus_name,
        // addr1: addr1,
        // addr2: addr2,
        // city: city,
        // postal: postal,
        // state: state
        if ($check_id  > 0) {
            $full_street = $request->addr1 . " " . $request->addr2;

            $locations->find($request->id)->update([
                'location_name' => $request->location_name,
                'street' => $request->addr1,
                'street2' => $request->addr2,
                'city' => $request->city,
                'state' => $request->state,
                'postal' => $request->postal

            ]);
            //DOUBLE CHECK THIS 07-26-2021
            if ($request->filled('phone') || $request->filled('email')) {

                if ($request->maps_url != "" || $request->maps_url != null) {
                    $validatedData = $request->validate([
                        'maps_url' => 'url'
                    ]);
                }
                if ($request->fax != "" || $request->fax != null) {
                    $validatedData = $request->validate([
                        'fax' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
                    ]);
                }
                $validatedData = $request->validate([
                    'email' => 'required|email:rfc,dns',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

                ]);
                //Check if this is an update
                $check_contacts = locationContacts::where('locations_id', $request->id)->count();
                if ($check_contacts > 0) {
                    //update
                    locationContacts::where('locations_id', $request->id)->update([
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'fax' => $request->fax,
                        'maps_url' => $request->maps_url
                    ]);
                } else {
                    //save
                    $location_contacts = new locationContacts();
                    $location_contacts->locations_id = $request->id;
                    $location_contacts->phone = $request->phone;
                    $location_contacts->email = $request->email;
                    $location_contacts->fax = $request->fax;
                    $location_contacts->maps_url = $request->maps_url;
                    $location_contacts->save();
                }
            }
            $check_locations_hours = location_hours::where("locations_id", $request->id)->get();
            parse_str($request->daysHours, $DaysHoursArray);
            foreach ($check_locations_hours as $hoursdays_info) {
                location_hours::where('id', $hoursdays_info->id)->where('locations_id', $request->id)->update([
                    'days' => $DaysHoursArray['day_' . $hoursdays_info->id],
                    'hours_from' => $DaysHoursArray['hours_from_' . $hoursdays_info->id],
                    'hours_to' => $DaysHoursArray['hours_to_' . $hoursdays_info->id],
                ]);
            }


            $response_messages['success'] = $request->location_name . " has been updated.";
        }
        $states = us_states::getStates();
        $daysData = hoursdays::getDays();
        foreach ($daysData as $days) {
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach ($hoursData as $hours) {
            $hours = json_decode($hours->hours, true);
        }
        $locations_data = $locations->with('location_hours')->orderBy('id', 'ASC')->get();
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Business Information Manager',
                'location_id' => $location_id,
                'view' => view('admin.layouts.partials.Mods.Locations.locations')->with([
                    "locations" => $locations_data,
                    'days' => $weekdays,
                    'hours' => $hours,
                    'states' => $states
                ])->render()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, locations $locations)
    {
        $response_messages = [];
        //Check to see if id exists in db
        $check_id = $locations->find($request->id);

        $locations->find($request->id)->forceDelete();
        $response_messages['success'] = $check_id->location_name . " has been deleted.";

        $states = us_states::getStates();
        $daysData = hoursdays::getDays();
        foreach ($daysData as $days) {
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach ($hoursData as $hours) {
            $hours = json_decode($hours->hours, true);
        }

        $locations_data = $locations->with('location_hours')->orderBy('id', 'ASC')->get();
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locations')->with([
                    "locations" => $locations_data,
                    'days' => $weekdays,
                    'hours' => $hours,
                    'states' => $states
                ])->render()
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroylocations(Request $request, location_hours $location_hours, locations $locations)
    {
        $response_messages = [];
        //Check to see if id exists in db
        $check_id = $location_hours->find($request->id);
        $location_id = $locations->find($check_id->locations_id);

        $location_hours->find($request->id)->forceDelete();
        $response_messages['success'] = $check_id->days . " has been deleted.";

        $states = us_states::getStates();
        $daysData = hoursdays::getDays();
        foreach ($daysData as $days) {
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach ($hoursData as $hours) {
            $hours = json_decode($hours->hours, true);
        }
        //resources/views/admin/layouts/partials/business.blade.php
        $locations_data = $locations->with('location_hours')->orderBy('id', 'ASC')->find($check_id->locations_id);
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'location_id' => $location_id,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locationsmodal')->with([
                    "location" => $locations_data,
                    'days' => $weekdays,
                    'hours' => $hours,
                    'states' => $states,
                    'show' => "show"

                ])->render()
            ]);
        }
    }

    public function addContactSection(Request $request, locations $locations)
    {

        $response_messages = [];
        $location_id = $locations->find($request->id);
        $locations_data = $locations->with('location_hours')->orderBy('id', 'ASC')->find($request->id);
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'location_id' => $location_id,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locationcontacts')->with([
                    "location" => $locations_data,
                    'show' => "show"

                ])->render()
            ]);
        }
    }


    public function addstorehoursrow(Request $request, location_hours $location_hours, locations $locations)
    {
        //passed through request: loc_id, count
        //Check the location_hours table and see if there are any already
        $row_count = location_hours::where('locations_id', $request->loc_id)->count();
        // dd($row_count);
        //if(is_countable($row_count)){
        if ($row_count < 7) {
            $save_row = new location_hours();
            $save_row->locations_id = $request->loc_id;
            $save_row->days = "Sunday";
            $save_row->hours_from = "00:00 AM";
            $save_row->hours_to = "00:00 AM";
            $save_row->created_at =  date('Y-m-d H:i:s');
            $save_row->updated_at = date('Y-m-d H:i:s');
            $save_row->save();
        }
        $get_location_hours_data = location_hours::with('LocationsHours')->get();
        foreach ($get_location_hours_data as $data) {
            // var_dump($data->LocationsHours);
        }

        $response_messages = [];
        //Check to see if id exists in db
        //$check_id = $location_hours->find($request->id);
        $location_id = $locations->find($request->loc_id);


        $response_messages['success'] = "New store days & hours row has been aded to " . $location_id->location_name;

        $states = us_states::getStates();
        $daysData = hoursdays::getDays();
        foreach ($daysData as $days) {
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach ($hoursData as $hours) {
            $hours = json_decode($hours->hours, true);
        }
        //resources/views/admin/layouts/partials/business.blade.php
        $locations_data = $locations->with('location_hours')->orderBy('id', 'ASC')->find($request->loc_id);
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'location_id' => $location_id,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locationsmodal')->with([
                    "location" => $locations_data,
                    'days' => $weekdays,
                    'hours' => $hours,
                    'states' => $states,
                    'show' => "show"

                ])->render()
            ]);
        }

        // }

    }


    /**
     * Business Controller needs:
     * 1. Add functionality (store)
     * 2. Update functionality (update)
     * 3. Delete functionality (destroy)
     *
     * It will need a model called locations
     * It will need a model called locations_services (what services are offered in which location)
     *
     * We will also need a file input (csv, xml, JSON) to add locations
     *
     * Google API (for contact us page & more... )<= TBD
     */
}
