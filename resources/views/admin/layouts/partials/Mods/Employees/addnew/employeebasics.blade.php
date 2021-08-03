{{-- This template will serve as the section for employee basic informtion
    employee name, middle, last name *
    employee address *
    employee phone number *
    employee image (if the have) (optional)
    emplouee emergancy contact information *
    employee marital informatio (married, single, divorced, choose not to answer, etc.) optional
    employee gender (male, female, no answer) --}}

{{-- Basic forms goes here --}}
<div id="add_employee_step_1" style="display: none;">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Name:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <input type="text" name="fname" id="fname" class="form-control" placeholder=""
                    aria-describedby="helpId1">
                <small id="helpId1" class="text-muted">Enter employee's first name</small>
            </div>

        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="">Middle:</label>
                <input type="text" name="mname" id="mname" class="form-control" placeholder=""
                    aria-describedby="helpId2">
                <small id="helpId2" class="text-muted">Optional</small>
            </div>

        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Last Name:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <input type="text" name="lname" id="lname" class="form-control" placeholder=""
                    aria-describedby="helpId3">
                <small id="helpId3" class="text-muted">Enter employee's first name</small>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Month</label>
                <select class="form-control form-control-sm" name="dob_month" id="dob_month">
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Day</label>
                <select class="form-control form-control-sm" name="dob_day" id="dob_day">
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Year</label>
                <select class="form-control form-control-sm" name="dob_year" id="dob_year">
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Gender</label>
                <select class="custom-select" name="gender" id="gender">
                    @php
                        $selected = '';
                        if (isset($request->gender)) {
                            $selected = 'selected';
                        }
                    @endphp
                    <option {{ $selected }}>Select one</option>
                    <option value="male" {{ $selected }}>Male</option>
                    <option value="female" {{ $selected }}>Female</option>
                    <option value="na" {{ $selected }}>Not Answered</option>
                </select>
            </div>
        </div>
    </div>
</div>
