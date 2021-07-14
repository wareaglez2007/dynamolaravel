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
            </tr>
        </thead>
        <tbody>

            @foreach ($locations as $location)
                <tr>
                    <th scope="row">{{ $location->id }}</th>
                    <td>{{ $location->location_name }}</td>
                    <td>{{ $location->street }}</td>
                    <td>{{ $location->city }}</td>
                    <td>{{ $location->state }}</td>
                    <td>{{ $location->postal }}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
@else
    <div class="col-md-12">
        <p>There are no locations currently for your business.</p>
    </div>
@endif
