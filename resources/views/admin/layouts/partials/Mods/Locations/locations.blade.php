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
                <tr >
                    <th scope="row"><a href="#" data-toggle="modal"
                            data-target="#locationeditmodal_{{ $location->id }}" > {{ $location->id }}</a></th>
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

                        @include('admin.layouts.partials.Mods.Locations.locationsmodal')
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
@else
    <div class="col-md-12">
        <p>There are no locations currently for your business.</p>
    </div>
@endif
