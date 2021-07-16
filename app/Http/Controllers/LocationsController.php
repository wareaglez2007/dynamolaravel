<?php

namespace App\Http\Controllers;

use App\hoursdays;
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
        $locations_data = locations::orderBy('id', 'ASC')->with('location_hours')->get();
        $daysData = hoursdays::getDays();
        foreach($daysData as $days){
            $weekdays = json_decode($days->week_days, true);
        }
        $hoursData = hoursdays::getHours();
        foreach($hoursData as $hours){
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
    public function store(Request $request, locations $locations)
    {
        //Save data into locations
        $response_messages = [];

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

        $response_messages['success'] = $request->location_name . " has been added.";
        $response_messages['locationid'] = $locations->id;

        $locations_data = $locations->orderBy('id', 'ASC')->get();


        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locations')->with([
                    "locations" => $locations_data
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
        if($check_id > 0){
            $full_street = $request->addr1 . " " . $request->addr2;

            $locations->find($request->id)->update([
                'location_name' => $request->location_name,
                'street' => $request->addr1,
                'street2' =>$request->addr2,
                'city' => $request->city,
                'state' => $request->state,
                'postal' => $request->postal

            ]);

            $response_messages['success'] = $request->location_name." has been updated.";
        }
        $locations_data = $locations->orderBy('id', 'ASC')->get();
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locations')->with([
                    "locations" => $locations_data
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

        $locations_data = $locations->orderBy('id', 'ASC')->get();
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Business Information Manager',
                'view' => view('admin.layouts.partials.Mods.Locations.locations')->with([
                    "locations" => $locations_data
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
