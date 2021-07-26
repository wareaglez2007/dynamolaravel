<div class="modal-body" id="modal_body_for_days_{{ $location->id }}">
    <form method="POST">
        <!---Business information section--->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Business Name:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
                    <input type="text" name="bus_name" id="bus_name_{{ $location->id }}" class="form-control"
                        placeholder="full business name" aria-describedby="helpId"
                        value="{{ $location->location_name }}">
                    <small id="helpId" class="text-muted">i.e. Dynamoelectric inc</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Business Address:</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address 1:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i><label>
                            <input type="text" name="addr1" id="addr1_{{ $location->id }}" class="form-control"
                                placeholder="123 cicrle st." aria-describedby="helpId"
                                value="{{ $location->street }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address 2:<label>
                            <input type="text" name="addr2" id="addr2_{{ $location->id }}" class="form-control"
                                placeholder="Apt,Suite#" aria-describedby="helpId" value="{{ $location->street2 }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">City:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
                    <input type="text" name="city" id="city_{{ $location->id }}" class="form-control"
                        placeholder="Los Angeles" aria-describedby="helpId" value="{{ $location->city }}">
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">State:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
                    <input type="text" name="state" id="state_{{ $location->id }}" class="form-control"
                        placeholder="CA" aria-describedby="helpId" value="{{ $location->state }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Zip/Postal Code:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
                    <input type="text" name="postal" id="postal_{{ $location->id }}" class="form-control"
                        placeholder="91234" aria-describedby="helpId" value="{{ $location->postal }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Business Contact Information:</h5>
            </div>
        </div>

        @if (is_countable($location->location_contacts) && count($location->location_contacts) > 0)
            <!--Locations contact information-->
            @foreach ($location->location_contacts as $contact_info)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Phone:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-telephone-inbound"></i></div>
                                </div>
                                <input type="phone" name="phone" id="phone_{{ $location->id }}" class="form-control"
                                    placeholder="800-996-9009" aria-describedby="helpId"
                                    value="{{ $contact_info->phone }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="email" name="email" id="email_{{ $location->id }}"
                                    class="form-control required" placeholder="yourside@yourdomain.com"
                                    aria-describedby="helpId" value="{{ $contact_info->email }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Fax:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-printer"></i></div>
                                </div>
                                <input type="text" name="fax" id="fax_{{ $location->id }}" class="form-control"
                                    placeholder="fax" aria-describedby="helpId"
                                    value="{{ $contact_info->fax }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Maps URL:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-pin"></i></div>
                                </div>
                                <input type="text" name="maps" id="maps_{{ $location->id }}" class="form-control"
                                    placeholder="google maps url" aria-describedby="helpId"
                                    value="{{ $contact_info->maps_url }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row" style="padding-bottom: 15px !important;"
                id="locations_contacts_div_{{ $location->id }}">
                <div class="col-md-12">
                    <!--The add button should be here-->
                    @php
                        if (count($location->location_contacts) == 1) {
                            $disabled = 'disabled';
                        } else {
                            $disabled = '';
                        }
                    @endphp

                    <a class="btn btn-primary btn-sm {{ $disabled }}"
                        id="add_contacts_btn_edit_{{ $location->id }}" href="#"
                        onclick="addContactstoEdit({{ $location->id }}, {{ count($location->location_contacts) }});">
                        <i class="bi bi-phone-vibrate"></i>
                        &nbsp; Add Contact Info
                    </a>

                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <h5>Business Days & Hours Information:</h5>
            </div>
        </div>
        <div class="row" style="padding-bottom: 15px !important;">
            <div class="col-md-4">
                <!--The add button should be here-->
                @php
                    if (count($location->location_hours) == 7) {
                        $disabled = 'disabled';
                    } else {
                        $disabled = '';
                    }
                @endphp

                <a class="btn btn-success btn-sm {{ $disabled }}" id="add_hours_btn_edit_{{ $location->id }}"
                    href="#"
                    onclick="addHourstoEdit({{ $location->id }}, {{ count($location->location_hours) }});">
                    <i class="bi bi-calendar2-plus-fill"></i>
                    &nbsp; Add Store hours
                </a>

            </div>
        </div>

        @if (is_countable($location->location_hours) && count($location->location_hours) > 0)
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Days</th>
                                <th>Open from</th>
                                <th>Open to</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($location->location_hours as $dayshours)
                                <tr id="hours_row_{{ $dayshours->id }}">
                                    <td scope="row">
                                        <select class="form-control form-control-sm" name="day"
                                            id="do_edit_day_{{ $dayshours->id }}" disabled>
                                            @foreach ($days as $i => $day)
                                                @if ($day == $dayshours->days)
                                                    {{ $selected = 'selected' }}
                                                    <option value="{{ $day }}" {{ $selected }}>
                                                        {{ $day }}
                                                    </option>
                                                @else
                                                    <option value="{{ $day }}">
                                                        {{ $day }}
                                                    </option>
                                                @endif

                                            @endforeach
                                        </select>

                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm" name="hours_from"
                                            id="do_edit_hours_from_{{ $dayshours->id }}" disabled>
                                            @foreach ($hours as $x => $hour)
                                                @if ($hour == $dayshours->hours_from)
                                                    {{ $selected = 'selected' }}
                                                    <option value="{{ $hour }}" {{ $selected }}>
                                                        {{ $hour }}</option>
                                                @else
                                                    <option value="{{ $hour }}">
                                                        {{ $hour }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm" name="hours_to"
                                            id="do_edit_hours_to_{{ $dayshours->id }}" disabled>
                                            @foreach ($hours as $x => $hour)
                                                @if ($hour == $dayshours->hours_to)
                                                    {{ $selected = 'selected' }}
                                                    <option value="{{ $hour }}" {{ $selected }}>
                                                        {{ $hour }}</option>
                                                @else
                                                    <option value="{{ $hour }}">
                                                        {{ $hour }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </td>
                                    <td><a href="#"
                                            onclick="editHoursRow({{ $dayshours->id }}, {{ $location->id }})"><i
                                                class="bi bi-pen-fill text-info"></i></a></td>
                                    <td><a href="#" onclick="deleteHoursRow({{ $dayshours->id }})"><i
                                                class="bi bi-node-minus text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!--Clone Day & Hours Div rows here -->
        <div id="additional_edit_{{ $location->id }}">

        </div>
        <!-- End of clones days & hours row -->

    </form>
</div>
