@if (is_countable($locations) && count($locations) > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Location Name</th>
                <th scope="col">Street</th>
                <th scope="col">City</th>
                <th scope="col">State</th>
                <th scope="col">Zip</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $location)
                <tr>
                    <th scope="row"><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}"> {{ $location->id }}</a></th>
                    <td><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}">{{ $location->location_name }}</a>
                    </td>
                    <td><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}">{{ $location->street }}
                            {{ $location->street2 }}</a></td>
                    <td><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}">{{ $location->city }}</a></td>
                    <td><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}">{{ $location->state }}</a></td>
                    <td><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}">{{ $location->postal }}</a></td>
                    <td><a href="#" onclick="DeleteLocation({{ $location->id }});"><i
                                class="bi bi-trash-fill text-danger"></i></a></td>
                </tr>

            @endforeach
        </tbody>
    </table>
@else
    <div class="col-md-12">
        <p>There are no locations currently for your business.</p>
    </div>
@endif

@if (is_countable($locations) && count($locations) > 0)
    @foreach ($locations as $location)
        <!-- Modal -->
        <div class="modal fade" id="locationeditmodal_{{ $location->id }}" tabindex="-1" role="dialog"
            aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">Edit {{ $location->location_name }}</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <!---Business information section--->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Business Name:</label>
                                        <input type="text" name="bus_name" id="bus_name_{{ $location->id }}"
                                            class="form-control" placeholder="full business name"
                                            aria-describedby="helpId" value="{{ $location->location_name }}">
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
                                        <label>Address 1:<label>
                                                <input type="text" name="addr1" id="addr1_{{ $location->id }}"
                                                    class="form-control" placeholder="123 cicrle st."
                                                    aria-describedby="helpId" value="{{ $location->street }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address 2:<label>
                                                <input type="text" name="addr2" id="addr2_{{ $location->id }}"
                                                    class="form-control" placeholder="Apt,Suite#"
                                                    aria-describedby="helpId" value="{{ $location->street2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">City:</label>
                                        <input type="text" name="city" id="city_{{ $location->id }}"
                                            class="form-control" placeholder="Los Angeles" aria-describedby="helpId"
                                            value="{{ $location->city }}">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">State:</label>
                                        <input type="text" name="state" id="state_{{ $location->id }}"
                                            class="form-control" placeholder="CA" aria-describedby="helpId"
                                            value="{{ $location->state }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Zip/Postal Code:</label>
                                        <input type="text" name="postal" id="postal_{{ $location->id }}"
                                            class="form-control" placeholder="91234" aria-describedby="helpId"
                                            value="{{ $location->postal }}">
                                    </div>
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
                                                    <tr>
                                                        <td scope="row">{{ $dayshours->days }}</td>
                                                        <td>{{ $dayshours->hours_from }}</td>
                                                        <td>{{ $dayshours->hours_to }}</td>
                                                        <td><i class="bi bi-pen-fill text-info"></i></td>
                                                        <td><i class="bi bi-node-minus text-danger"></i></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="row" style="padding-bottom: 15px !important;">
                                    <div class="col-md-4">
                                        <!--The add button should be here-->
                                        <a class="btn btn-success btn-sm" id="add_hours_btn_edit" href="#">
                                            <i class="bi bi-calendar2-plus-fill"></i>
                                            &nbsp; Add Store hours
                                        </a>

                                    </div>
                                </div>

                                <!--Clone Day & Hours Div rows here -->
                                <div id="additional_edit">

                                </div>
                                <!-- End of clones days & hours row -->

                            @endif
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="location_editor"
                            onclick="EditLocation({{ $location->id }})">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!---End of Edit modal -->
@endif
