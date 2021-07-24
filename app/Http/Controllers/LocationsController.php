<?php

namespace App\Http\Controllers;

use App\hoursdays;
use App\location_hours;
use App\locations;
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
        $locations_data = locations::with('location_hours')->orderBy('id', 'ASC')->with('location_hours')->get();
        $daysData = hoursdays::getDays();
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
            'hours' => $hours
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
            'postal' => ['required'],
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
                    'hours' => $hours
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
            'postal' => ['required'],
            'city' => ['required'],
            'state' => ['required'],

        ]);
        //Check to see if id exists in db
        $check_id = $locations->find($request->id)->count();
        // location_name: bus_name,
        // addr1: addr1,
        // addr2: addr2,
        // city: city,
        // postal: postal,
        // state: state
        if ($check_id > 0) {
            $full_street = $request->addr1 . " " . $request->addr2;

            $locations->find($request->id)->update([
                'location_name' => $request->location_name,
                'street' => $request->addr1,
                'street2' => $request->addr2,
                'city' => $request->city,
                'state' => $request->state,
                'postal' => $request->postal

            ]);
            $check_locations = location_hours::where("locations_id", $request->id)->get();
            //var_dump($request->numrows);
            //var_dump($request->id);
            if (count($check_locations) > 0 || (is_countable($request->numrows) && count($request->numrows) > 0)) {
                //Update
                if (is_countable($request->editing_days) && count($request->editing_days) > 0) {
                    foreach ($request->editing_days as $cur_store_hours) {
                        location_hours::where('id', $cur_store_hours)->where('locations_id', $request->id)->update([
                            'days' => $request->editing_days_values['old_days_' . $cur_store_hours],
                            'hours_from' => $request->editing_days_values['old_hours_from_' . $cur_store_hours],
                            'hours_to' => $request->editing_days_values['old_hours_to_' . $cur_store_hours],
                        ]);
                    }
                }


                //Save
                if (is_countable($request->numrows) && count($request->numrows) > 0) {
                    foreach ($request->numrows as $i) {
                        if ($request->days['day_edit_for_' . $request->id . "_" . $i] != null) {
                            $location_hours = new location_hours();
                            $location_hours->days = $request->days['day_edit_for_' . $request->id . "_" . $i];
                            $location_hours->hours_from = $request->days['hours_from_edit_for_' . $request->id . "_" . $i];
                            $location_hours->hours_to = $request->days['hours_to_edit_for_' . $request->id . "_" . $i];
                            $location_hours->locations_id = $request->id;
                            $location_hours->save();
                        }

                        //$locations->location_hours()->save($location_hours);
                    }
                }
            }


            $response_messages['success'] = $request->location_name . " has been updated.";
        }
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
                    'hours' => $hours
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
                    'hours' => $hours
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
                    'show' => "show"

                ])->render()
            ]);
        }
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
