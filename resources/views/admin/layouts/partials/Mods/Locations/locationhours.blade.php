<div class="row" style="padding-bottom: 5px !important;">
    <div class="col-md-4">
        <!--The add button should be here-->
        <a class="btn btn-success btn-sm" id="add_hours_btn" href="#" >
            <i class="bi bi-calendar2-plus-fill"></i>
            &nbsp; Add Store hours
        </a>

    </div>
</div>
<div class="row" id="location_hours_div_1" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Days:</label>
            <select class="form-control" name="day" id="day_1">
                @foreach ($days as $i => $day)
                    <option value="{{ $i }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Hours From:</label>
            <select class="form-control" name="hours_from" id="hours_from_1">
                @foreach ($hours as $x => $hour)
                    <option value="{{ $x }}">{{ $hour }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Hours To:</label>
            <select class="form-control" name="hours_to" id="hours_to_1">
                @foreach ($hours as $x => $hour)
                    <option value="{{ $x }}">{{ $hour }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="col-md-3">
        <a href="#" onclick="ClearDayRow(1)" id="clearday_1"><i class="bi bi-dash-circle text-danger"></i></a>

    </div>
</div>
<!--Append additional rows here -->
<div id="additional">

</div>
<!-- End of additional days & hours row -->
