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
        //$object = (object) $array;
        $response_messages = [];
        //var_dump($request->steps);
        switch ($request->steps) {
            case 1:
                $view = 'admin.layouts.partials.Mods.Employees.addnew.employeebasics';
                $response_messages['success'] = "";
                $modal_title = "Employee basic information";
                $current_step = 1;
                $forward_step = 2;
                $backward_step = 0;
                $progress = 25;
                break;
            case 2:
                $view = 'admin.layouts.partials.Mods.Employees.addnew.employeeaddress';
                $response_messages['success'] = "Basic Employee information added.";
                $modal_title = "Employee address information";
                $current_step = 2;
                $forward_step = 3;
                $backward_step = 1;
                $progress = 50;


                // $validatedData = $request->validate([
                //     'fname' => 'required',
                //     'lname' => 'required',
                //     'dob_month' => 'required',
                //     'dob_day' => 'required',
                //     'dob_year' => 'required',
                //     'gender' => 'required'
                // ]);

                break;
            case 3:
                $view = 'admin.layouts.partials.Mods.Employees.addnew.employeecontact';
                $response_messages['success'] = "Employee address information added.";
                $modal_title = "Employee contact information";
                $current_step = 3;
                $forward_step = 4;
                $backward_step = 2;
                $progress = 75;
                break;
            case 4:
                $view = 'admin.layouts.partials.Mods.Employees.addnew.employeeresume';
                $response_messages['success'] = "Employement information added.";
                $modal_title = "Employment information";
                $current_step = 4;
                $forward_step = 0;
                $backward_step = 3;
                $progress = 100;
                break;
            default:
                $view = 'admin.layouts.partials.Mods.Employees.addnew.employeebasics';
                $response_messages['success'] = "Basic Employee information added.";
                $modal_title = "Employee basic information";
                $current_step = 1;
                $forward_step = 2;
                $backward_step = 0;
                $progress = 25;
                break;
        }

        //Put all form values in session
        $request->session()->put('basics', $request->all());
        $dob = $request->dob_month . "/" . $request->dob_day . "/" . $request->dob_year;
        $name = $request->fname;
        $mname = $request->mname;
        $lname = $request->lname;
        $gender = $request->gender;

        $employee_basics = new employees();
        $employee_address = new employee_addresses();
        $employee_contacts = new employee_contacts();
        $employee_resumes = new employee_resumes();
        $employee_locations = new employee_locations();
        // if($counter == 1){
        //     $employee_basics->fname = $name;
        //     $employee_basics->mname = $mname;
        //     $employee_basics->lname = $lname;
        //     $employee_basics->dob = $dob;
        //     $employee_basics->gender = $gender;
        //     $employee_basics->save();

        //     $employee_address->employees_id = $employee_basics->id;
        //     $employee_address->save();
        //     $employee_contacts->employees_id = $employee_basics->id;
        //     $employee_contacts->email = $this->generateRandomString(10)."@gmail.com";
        //     $employee_contacts->save();
        //     $employee_resumes->employees_id = $employee_basics->id;
        //     $employee_resumes->added_by = "user1";
        //     $employee_resumes->save();
        //     Session(['empid' => $employee_basics->id]);
        // }else{
        //     //Update otherwaise
        //    // $employee_basics->where()->update([

        //     //]);
        // }



        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Employees Information Management Module',
                'current_step' => $current_step,
                'forward_step' => $forward_step,
                'backward_step' => $backward_step,
                'progress' => $progress,
                'request' => $request->all(),
                'modal_title' => $modal_title,
                'input_data' => $request->session()->get('basics'),
                'view' => view($view)->with([
                    'modal_title' => $modal_title,
                    'states' => $this->getStates(),
                    'input_data' => $request->session()->get('basics'),
                ])->render()
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
