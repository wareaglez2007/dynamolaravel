{{-- This template will serve as the section for employee basic informtion
    employee name, middle, last name *
    employee address *
    employee phone number *
    employee image (if the have) (optional)
    emplouee emergancy contact information *
    employee marital informatio (married, single, divorced, choose not to answer, etc.) optional
    employee gender (male, female, no answer) --}}

{{-- Basic forms goes here --}}




<div id="add_employee_step_1">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Name:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <input type="text" name="fname" id="fname" class="form-control" placeholder=""
                    aria-describedby="helpId1" value="">
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
                <label for="">Month:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <select class="form-control form-control-sm" name="dob_month" id="dob_month">
                    <option value='' selected>Select month</option>
                    @for ($i = 1; $i < 13; $i++)
                        @if ($i < 10) <option value="{{ $i }}">0{{ $i }}</option> 
        @else
                         <option value="{{ $i }}">{{ $i }}</option> @endif @endfor

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Day:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <select class="form-control form-control-sm" name="dob_day" id="dob_day">
                    <option value='' selected>Select day</option>
                    @for ($i = 1; $i < 32; $i++)
                        @if ($i < 10) <option value="{{ $i }}">0{{ $i }}</option> 
   @else
                    <option value="{{ $i }}">{{ $i }}</option> @endif @endfor
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Year:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <select class="form-control form-control-sm" name="dob_year" id="dob_year">
                    <option value='' selected>Select year</option>
                    @for ($i = 1950; $i < 2022; $i++)
                        <option value='{{ $i }}'>{{ $i }}</option>
                    @endfor

                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Gender<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <select class="custom-select" name="gender" id="gender">
                    @php
                        $selected = '';
                        if (isset($request->gender)) {
                            $selected = 'selected';
                        }
                    @endphp
                    <option value="" selected>Select one</option>
                    <option value="male" {{ $selected }}>Male</option>
                    <option value="female" {{ $selected }}>Female</option>
                    <option value="na" {{ $selected }}>Not Answered</option>
                </select>
            </div>
        </div>
    </div>
</div>

