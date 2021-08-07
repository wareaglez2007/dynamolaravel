<?php

namespace App\Http\Controllers;

use App\employee_addresses;
use App\employee_contacts;
use App\employee_locations;
use App\employee_resumes;
use App\employees;
use Illuminate\Http\Request;
use App\locations;
use App\locationContacts;
use App\us_states;
use Illuminate\Support\Facades\Session;

class EmployeesController extends Controller
{
    private $states;
    public function __construct()
    {
        $this->middleware('auth');
        $this->setStates(us_states::getStates());
    }

    public function getStates()
    {
        return $this->states;
    }
    public function setStates($states)
    {
        $this->states = $states;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$states = us_states::getStates();
        return view('admin.modules.general', [
            'mod_name' => 'Employees Information Management Module',
            'states' => $this->getStates(),
            'modal_title' => 'Employee Basic Information'

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $response_messages = [];
        $reset = false;
        switch ($request->steps) {
            case 1:
                $validatedData = $request->validate([
                    'fname' => 'required',
                    'lname' => 'required',
                    'dob_month' => 'required',
                    'dob_day' => 'required',
                    'dob_year' => 'required',
                    'gender' => 'required'
                ]);
                $response_messages['success'] = "Basic Employee information added.";
                break;
            case 2:
                $validatedData = $request->validate([
                    'add1' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'postal' => 'required|regex:/^[0-9]{3,7}$/'
                ]);
                $response_messages['success'] = "Employee address information added.";
                break;
            case 3:
                $validatedData = $request->validate([
                    'email' => 'required|email:rfc,dns',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                ]);
                $response_messages['success'] = "Employee contact information added.";
                break;
            case 4:
                $response_messages['success'] = "Employement information added.";
                break;
            case 5:
                // //Save
                // $dob = $request->dob_month . "/" . $request->dob_day . "/" . $request->dob_year;
                // $name = $request->fname;
                // $mname = $request->mname;
                // $lname = $request->lname;
                // $gender = $request->gender;
        
                // $employee_basics = new employees();
                // $employee_address = new employee_addresses();
                // $employee_contacts = new employee_contacts();
                // $employee_resumes = new employee_resumes();
                // $employee_locations = new employee_locations();

                // $employee_basics->fname = $name;
                // $employee_basics->mname = $mname;
                // $employee_basics->lname = $lname;
                // $employee_basics->dob = $dob;
                // $employee_basics->gender = $gender;
                // $employee_basics->save();
    
                // $employee_address->employees_id = $employee_basics->id;
                // $employee_address->save();
                // $employee_contacts->employees_id = $employee_basics->id;
                // $employee_contacts->email = $this->generateRandomString(10)."@gmail.com";
                // $employee_contacts->save();
                // $employee_resumes->employees_id = $employee_basics->id;
                // $employee_resumes->added_by = "user1";
                // $employee_resumes->save();
                // $response_messages['success'] = "Employee information has been saved.";
                // $reset = true;
                break;
            default:
                $response_messages['success'] = "Basic Employee information added.";
                break;
        }

        //Put all form values in session
        $request->session()->put('basics', $request->all());

        



        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                "reset" => $reset,
                'mod_name' => 'Employees Information Management Module'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(employees $employees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employees $employees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(employees $employees)
    {
        //
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
