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

class EmployeesController extends Controller
{
    private $states;
    private $_additon_code;
    private $_emailRule;



    public function __construct()
    {
        $this->middleware('auth');
        $this->setStates(us_states::getStates());
        $this->set_addition_code(0); //initialized at zero
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
     * 
     */
    private function get_addition_code()
    {
        return $this->_additon_code;
    }
    /**
     * 
     */
    private function set_addition_code($code)
    {
        $this->_additon_code = $code;
    }

    private function getEmailRules()
    {
        return $this->_emailRule;
    }
    private function setEmailRules($rule)
    {
        $this->_emailRule = $rule;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->show();
        //$states = us_states::getStates();
        return view('admin.modules.general', [
            'mod_name' => 'Employees Information Management Module',
            'states' => $this->getStates(),
            'modal_title' => 'Employee Basic Information',
            'employees' => $data

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
        $employee_locations = new employee_locations();

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

        //Update the contacts
        $employee_contacts->where('employees_id', $employee_basics->id)->update([
            'phone1' => $request->phone,
            'phone2' => $request->sec_phone
        ]);
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
        $view = "admin.modules.general";
        $employee_count = employee_contacts::where('email', $request->email)->count();
        //if the count is gretaer than zero that means it has been added!
        if ($employee_count > 0) {
            $empid =  employee_contacts::where('email', $request->email)->get();
            $this->set_addition_code(1);
            foreach ($empid as $emloyee_uid) {
            }
            $employee_address_count = employee_addresses::where('employees_id', $emloyee_uid->employees_id)->count();
        } else {
            $employee_count = 0;
        }
        if ($request->steps > 4) {
            $request->steps = 4;
        }

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

               
                //Final step

                break;
                //default:
                //   $response_messages['success'] = "Basic Employee information added.";
                //  break;
        }

        //Put all form values in session

        if ($employee_count == 0) {
            $this->create($request);
            $response_messages['success'] = "Employement information added.";
            $reset = true;
            $view = 'admin.layouts.partials.Mods.Employees.edit.showcurrentemployees';
        //} else {
           // $response_messages['warning'] = "Employee has been added.please add new info.";
          //  $reset = true;
            // if($emloyee_uid->email != $request->email){
            //     $response_messages['warning'] = "You have changed the email address!!!";
            // }
            // //update
            // employees::where('id', $emloyee_uid->employees_id)->update([
            //     'fname' => $request->fname,
            //     'mname' => $request->mname,
            //     'lname' => $request->lname,
            //     'dob' => $request->dob_month . "/" . $request->dob_day . "/" . $request->dob_year,
            //     'gender' => $request->gender,
            // ]);
            // employee_contacts::where('employees_id', $emloyee_uid->employees_id)->update([
            //     'email' => $request->email
            // ]);
            // $response_messages['success'] = "Basic employee information has been updated.";
        }




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
