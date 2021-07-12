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
                    <!---Business information section--->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Business Name:</label>
                                <input type="text" name="" id="" class="form-control" placeholder="full business name"
                                    aria-describedby="helpId">
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
                                        <input type="text" name="addr1" id="add1" class="form-control"
                                            placeholder="123 cicrle st." aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address 2:<label>
                                        <input type="text" name="addr2" id="add2" class="form-control"
                                            placeholder="Apt,Suite#" aria-describedby="helpId">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">City:</label>
                                <input type="text" name="" id="" class="form-control" placeholder="LoS Angeles"
                                    aria-describedby="helpId">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">State:</label>
                                <input type="text" name="" id="" class="form-control" placeholder="CA"
                                    aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Zip/Postal Code:</label>
                                <input type="text" name="" id="" class="form-control" placeholder="91234"
                                    aria-describedby="helpId">
                            </div>
                        </div>
                    </div>

                    <!--Business address ends-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--EDIT PAGE SECTION-->
    <script src="{{ asset('js/locationajax.js') }}" defer></script>
    <!---END OF AJAX JS-->
