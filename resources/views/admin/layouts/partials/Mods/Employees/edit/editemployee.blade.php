@extends('admin.layouts.app')

@section('content')
    <div class="card">
        {{-- Edit employee information 08-14-2021 --}}
        <div class="card-header">{{ $mod_name }}</div>
        <div class="card-body" style="background-color: #f8f9fa!important;">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div>
                                <h5 class="my-0">Edit Instructions</h5>
                                <small class="text-muted">Steps</small>
                            </div>
                        </li>
                        <li class="list-group-item">Step 1:</li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <form id="edit_employee">
                        {{-- Employee basics --}}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">First Name<i class="bi bi-asterisk text-danger"
                                            style="font-size: 8px;vertical-align: top;"></i></label>
                                    <input type="text" name="fname" id="fname" class="form-control" placeholder=""
                                        aria-describedby="helpId" value="{{ $employee->fname }}">
                                    <small id="helpId" class="text-muted">Employee first name</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Middle Name</label>
                                    <input type="text" name="mname" id="mname" class="form-control" placeholder=""
                                        aria-describedby="helpId" value="{{ $employee->mname }}">
                                    <small id="helpId" class="text-muted">Employee middle name</small>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Last Name<i class="bi bi-asterisk text-danger"
                                            style="font-size: 8px;vertical-align: top;"></i></label>
                                    <input type="text" name="lname" id="lname" class="form-control" placeholder=""
                                        aria-describedby="helpId" value="{{ $employee->lname }}">
                                    <small id="helpId" class="text-muted">Employee last name</small>
                                </div>
                            </div>

                        </div>

                        {{-- Employee address --}}
                        @if (is_countable($employee->employee_address))
                            @foreach ($employee->employee_address as $address)
                                <div class="row">


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address 1</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                                                placeholder="" value="{{ $address->street1 }}">
                                            <small id="helpId" class="form-text text-muted">Help text</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address 2 <span class="text-muted">(Optional)</span></label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                                                placeholder="" value="{{ $address->street2 }}">
                                            <small id="helpId" class="form-text text-muted">Help text</small>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    {{-- city --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">City </label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                                                placeholder="" value="{{ $address->city }}">
                                            <small id="helpId" class="form-text text-muted">Help text</small>
                                        </div>
                                    </div>
                                    {{-- state --}}
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label for="">State:<i class="bi bi-asterisk text-danger"
                                                    style="font-size: 8px;vertical-align: top;"></i></label>

                                            <select class="form-control" name="state" id="state">
                                                @foreach ($states as $state)
                                                    @php
                                                        $selected = '';
                                                        if ($address->county == $state->state) {
                                                            $selected = 'selected';
                                                        }
                                                    @endphp
                                                    <option value="{{ $state->state }}" {{ $selected }}>
                                                        {{ $state->state_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    {{-- zip code --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Postal</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                                                placeholder="" value="{{ $address->street2 }}">
                                            <small id="helpId" class="form-text text-muted">Help text</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Employee contacts --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email<i class="bi bi-asterisk text-danger"
                                            style="font-size: 8px;vertical-align: top;"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">@</div>
                                        </div>
                                        @if (is_countable($employee->employee_contacts))
                                            @foreach ($employee->employee_contacts as $contact)

                                            @endforeach
                                            <input type="email" name="email" id="email" class="form-control required"
                                                placeholder="yourside@yourdomain.com" aria-describedby="helpId"
                                                value="{{ $contact->email }}">
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Secondary Email <span class="text-muted">(Optional)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">@</div>
                                        </div>
                                        <input type="email" name="sec_email" id="sec_email" class="form-control required"
                                            placeholder="yourside@yourdomain.com" aria-describedby="helpId" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- employee work location/s --}}
                        <div class="row">

                        </div>

                        {{-- manager employee work history --}}
                        <div class="row">

                        </div>

                        {{-- employee work hours --}}
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
