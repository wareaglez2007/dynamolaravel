{{-- This section is for employee work location
    it should be a drop down for different locations
    use Select 2 drop down for this option

    ***Look into https://github.com/select2/select2/packages/33875?version=4.1.0-rc.0 --}}

<div id="add_employee_step_4" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Locations</label>
                <select multiple class="form-control" name="locations[]" id="employee_locations" style="width: 100% !important;">
                    @if (is_countable($locations) && count($locations) > 0)
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                        @endforeach

                    @endif
                </select>
            </div>
        </div>
    </div>

</div>
