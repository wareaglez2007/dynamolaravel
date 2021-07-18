<div class="row" style="padding-bottom: 15px !important;">
    <div class="col-md-4">
        <!--The add button should be here-->
        <a class="btn btn-success btn-sm" id="add_hours_btn" href="#">
            <i class="bi bi-calendar2-plus-fill"></i>
            &nbsp; Add Store hours
        </a>

    </div>
</div>
<!--Days & Hours will be cloned from here -->
<div class="row" id="location_hours_div" style="display: none;">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Days:</label>
            <select class="form-control form-control-sm" name="day" id="day_1">
                @foreach ($days as $i => $day)
                    <option value="{{ $i }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-row align-items-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">Hours From:</label>
                    <select class="form-control form-control-sm" name="hours_from" id="hours_from_1">
                        @foreach ($hours as $x => $hour)
                            <option value="{{ $x }}">{{ $hour }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">Hours To:</label>
                    <select class="form-control form-control-sm" name="hours_to" id="hours_to_1">
                        @foreach ($hours as $x => $hour)
                            <option value="{{ $x }}">{{ $hour }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    <a href="#" onclick="ClearDayRow(1)" id="clearday_1"><i
                            class="bi bi-dash-circle text-danger"></i></a>
                </div>
            </div>
        </div>
    </div>

</div>
<!--- end of days & hours original copy -->
<!--Clone Day & Hours Div rows here -->
<div id="additional">

</div>
<!-- End of clones days & hours row -->
