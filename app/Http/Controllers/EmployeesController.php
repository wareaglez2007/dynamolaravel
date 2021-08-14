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
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class EmployeesController extends Controller
{
    private $states;
    private $_additon_code;
    private $_emailRule;
    private $locations_for_work;
    private $employee_locations;
    private $employee_id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->setStates(us_states::getStates()); //Initailized states
        $this->set_addition_code(0); //initialized at zero
        $this->locations_for_work = locations::get(); //Initializes the ocations for drop down

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
     * returns addition code
     */
    private function get_addition_code()
    {
        return $this->_additon_code;
    }
    /**
     * set addition code
     */
    private function set_addition_code($code)
    {
        $this->_additon_code = $code;
    }

    /**
     * return email rules
     */
    private function getEmailRules()
    {
        return $this->_emailRule;
    }
    /**
     * Set email rules
     */
    private function setEmailRules($rule)
    {
        $this->_emailRule = $rule;
    }
    /**
     * get employee id
     */
    private function getEmployeeId()
    {
        return $this->employee_id;
    }
    /**
     * set employee id
     */

    private function setEmployeeId($empid)
    {
        $this->employee_id = $empid;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->show();
        return view('admin.modules.general', [
            'mod_name' => 'Employees Information Management Module',
            'states' => $this->getStates(),
            'modal_title' => 'Employee Basic Information',
            'employees' => $data,
            'locations' => $this->locations_for_work

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $employee_basics = new employees();
        $employee_address = new employee_addresses();
        $employee_contacts = new employee_contacts();
        $employee_resumes = new employee_resumes();


        //Save and use email as the primary id
        $employee_basics->fname = $request->fname;
        $employee_basics->mname = $request->mname;
        $employee_basics->lname = $request->lname;
        $employee_basics->dob = $request->dob_month . "/" . $request->dob_day . "/" . $request->dob_year;
        $employee_basics->gender = $request->gender;
        $employee_basics->save();
        $employee_contacts->email = $request->email; //add email
        $employee_basics->employee_contacts()->save($employee_contacts);

        $employee_address->street1 = $request->add1;
        $employee_address->street2 = $request->add2;
        $employee_address->city = $request->city;
        $employee_address->county = $request->state;
        $employee_address->zipcode = $request->postal;
        $employee_basics->employee_address()->save($employee_address);

        //set employee id for global use
        $this->setEmployeeId($employee_basics->id);
        //Update the contacts
        $employee_contacts->where('employees_id', $employee_basics->id)->update([
            'phone1' => $request->phone,
            'phone2' => $request->sec_phone
        ]);
        //Add mulitple locations
        foreach ($request->locations as $location) {
            $this->employee_locations  = new employee_locations();
            $this->employee_locations->locations_id = $location;
            $this->employee_locations->employees_id = $this->getEmployeeId();
            $this->employee_locations->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->create($request);


        $response_messages['success'] = "Employement information added.";
        $reset = true;
        $view = 'admin.layouts.partials.Mods.Employees.edit.showcurrentemployees';

        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                "reset" => $reset,
                "step" => $this->get_addition_code(),
                'mod_name' => 'Employees Information Management Module',
                'view' => view($view)->with([
                    "employees" => $this->show(),
                ])->render()
            ]);
        }
    }


    public function validateForms(Request $request)
    {

        switch ($request->steps) {
            case 1:
                if ($this->get_addition_code() == 0) {
                    $this->setEmailRules('|unique:employee_contacts,email');
                }
                $validatedData = $request->validate([
                    'fname' => 'required',
                    'lname' => 'required',
                    'email' => 'required|email:rfc,dns' . $this->getEmailRules(),
                    'dob_month' => 'required',
                    'dob_day' => 'required',
                    'dob_year' => 'required',
                    'gender' => 'required'
                ]);
                $response_messages['success'] = "Basic Employee information looks good.";
                break;
            case 2:
                $validatedData = $request->validate([
                    'add1' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'postal' => 'required|regex:/^[0-9]{3,7}$/'
                ]);
                $response_messages['success'] = "Employee address information looks good.";
                break;
            case 3:
                $validatedData = $request->validate([
                    'sec_email' => 'email:rfc,dns',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'sec_phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                ]);
                $response_messages['success'] = "Employee contact information looks good..";
                break;
            case 4:

                $response_messages['success'] = "Employee work history looks good..";
                //Final step

                break;
            case 5:

                $response_messages['success']['code'] = 200;

                break;
            default:
                //   $response_messages['success'] = "Basic Employee information added.";
                break;
        }

        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = employees::with('employee_address')->with('employee_contacts')->get();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(employees $employees, $id)
    {
        //
        $employee = $employees->with('employee_contacts')->with('employee_address')->with('employee_locations')->find($id);
        $view = 'admin.layouts.partials.Mods.Employees.edit.editemployee';
        return view($view, [
            'mod_name' => 'Employees Information Management Module',
            'states' => $this->getStates(),
            'modal_title' => 'Employee Basic Information',
            'employee' => $employee,
            'locations' => $this->locations_for_work

        ]);
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
    public function destroy(employees $employees, Request $request)
    {
        $employee = $employees->find($request->id);
        $employees->find($request->id)->forceDelete();
        $view = 'admin.layouts.partials.Mods.Employees.edit.showcurrentemployees';
        $response_messages['success'] = $employee->fname . " " . $employee->mname . " " . $employee->lname . " has been deleted.";


        $data = $this->show();

        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'mod_name' => 'Employees Information Management Module',

                'locations' => $this->locations_for_work,
                'view' => view($view)->with([
                    'states' => $this->getStates(),
                    'modal_title' => 'Employee Basic Information',
                    'employees' => $data,
                ])->render()
            ]);
        }
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

    public function resetmodal(Request $request)
    {
        var_dump($request->all());
        $request->steps = 1;
        $response_messages['success']['code'] = 200;
        ///Users/rostomsahakian/Documents/Dynamolaravel/resources/views/admin/layouts/partials/Mods/Employees/addnew/addnewemployeemodal.blade.php
        $view = 'admin.layouts.partials.Mods.Employees.addnew.addnewemployeemodal';
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'view' => view($view)->with([
                    "employees" => $this->show(),
                    'mod_name' => 'Employees Information Management Module',
                    'states' => $this->getStates(),
                    'modal_title' => 'Employee Basic Information',

                ])->render()
            ]);
        }
    }
}
