<div class="card-header">{{ $mod_name }}</div>
<div class="card-body">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modelId">
        <i class="bi bi-journal-plus"></i> Add New Info
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Business Information:</h5>
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
                                    <input type="text" name="bus_name" id="bus_name" class="form-control"
                                        placeholder="full business name" aria-describedby="helpId">
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
                                            <input type="text" name="addr1" id="addr1" class="form-control"
                                                placeholder="123 cicrle st." aria-describedby="helpId">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address 2:<label>
                                            <input type="text" name="addr2" id="addr2" class="form-control"
                                                placeholder="Apt,Suite#" aria-describedby="helpId">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">City:</label>
                                    <input type="text" name="city" id="city" class="form-control"
                                        placeholder="Los Angeles" aria-describedby="helpId">
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">State:</label>
                                    <input type="text" name="state" id="state" class="form-control" placeholder="CA"
                                        aria-describedby="helpId">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Zip/Postal Code:</label>
                                    <input type="text" name="postal" id="postal" class="form-control"
                                        placeholder="91234" aria-describedby="helpId">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Days:</label>
                                    <select class="form-control" name="" id="">
                                        @foreach ($days as $i => $day)
                                            <option value="{{ $i }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hours From:</label>
                                    <select class="form-control" name="" id="">
                                        @foreach ($hours as $x => $hour)
                                            <option value="{{ $x }}">{{ $hour }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hours To:</label>
                                    <select class="form-control" name="" id="">
                                        @foreach ($hours as $x => $hour)
                                            <option value="{{ $x }}">{{ $hour }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </form>
                    <!--Business address ends-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="savelocations()">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!--Locations section-->
<div class="col-md-12" id="locations_div">
    @include('admin.layouts.partials.Mods.Locations.locations')

</div>

<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999999; right: 0; bottom: 0;" id="bottom_toast">
</div>
<!--EDIT PAGE SECTION-->
<script src="{{ asset('js/locationajax.js') }}" defer></script>
<!---END OF AJAX JS-->
