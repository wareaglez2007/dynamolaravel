@if (is_countable($editview->fileforpages) && count($editview->fileforpages) > 0)
    <div class="row">

        @foreach ($editview->fileforpages as $file)

            <div class="col-md-1" style="margin-bottom: 15px" id="uploadedimages">

                <div class="small_square">

                    <a href="{{ $file->id }}" id="{{ $file->id }}" data-toggle="modal"
                        data-target="#attached_image_modal_{{ $file->id }}"
                        title="{{ asset('storage/thumbnails/' . $file->file_name) }}"
                        onclick="event.preventDefault();">
                    <img src="{{ asset('storage/resource-images/' . $file->extension.".png") }}"  />
                    </a>
                </div>
            </div>

            <!-- Modal for attached images pop up -->
            <div class="modal fade" id="attached_image_modal_{{ $file->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel_{{ $file->id }}">Name:
                                {{ $file->file_name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!--image-->
                                    <img src="{{ asset('storage/resource-images/' . $file->extension.".png") }}" class="img-thumbnail "
                                        class="upload-img-thumbnail" alt="/images/thumbs/{{ $file->file_name }}" />
                                    <!--link to image-->
                                    <small class="text-muted"><b>Link:
                                        </b>{{ asset('storage/' . $file->storage_path) }}</small>
                                </div>
                                <div class="col-md-6">
                                    <!--Edit image properties-->
                                    <div class="form-group">
                                        <label for="">Title:</label>
                                        <input type="text" class="form-control"
                                            value="{{ $file->file_name }}" name="title_{{ $file->id }}"
                                            id="title_{{ $file->id }}" aria-describedby="helpId" placeholder="">

                                    </div>


                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <form action="{{ URL::to('/admin/Images/updateimagesinfo') }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-primary"
                                    onclick="EditAttachedImageprops({{ $file->id }})">Save
                                    changes</button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="DetachImagesFromPage({{ $editview->id }},{{ $file->id }});"><i
                                        class="bi bi-x-square"></i> Detach Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="col-md-12">
        <p>There are currently no images uploaded.</p>
    </div>
@endif
<script>
    function EditAttachedImageprops(id) {

        var image_name = $("#title_" + id).val();
        var image_alt_text = $("#alt_" + id).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                        'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }

        }); //End of ajax setup
        $.ajax({
            url: "/admin/Images/updateimagesinfo",
            method: "post",
            //cache: false,
            data: {
                id: id,
                image_name: image_name,
                image_alt_text: image_alt_text,
            },
            success: function(data) {
                var delay = 2300;
                color = "green";

                var toast =

                    '<div id="attached_toast_id_' + id +
                    '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                    delay + '" >' +
                    '<div class="toast-header" style="background-color: ' +
                    color +
                    ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                    '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                    '<div class="toast-body" id="toast_id_body' +
                    id + '">' + data.success +
                    '</div> </div> </div>';
                $("#bottom_toast").append(toast);
                $('#attached_toast_id_' + id).toast("show");
                setTimeout(function() {
                    $('#attached_toast_id_' + id)
                        .remove();
                }, delay + 500);

            }, //end of success
            error: function(error) {

                $("#ajaxactioncallimages").attr('class', "alert alert-danger");
                $.each(error.responseJSON.errors, function(index, val) {
                    $("#ajaxactioncallimages #e_message").html(
                        "<img src='/storage/ajax-loader-red.gif'/>" + val);
                    //   $('#ajaxactioncallimages').fadeOut(2500);
                    // console.log(index, val);
                });

                // console.log(error);


            } //end of error
        }); //end of ajax
        //Edit title
        //Edit size
        //Edit alt text

    } //end of EditAttachedImageprops



</script>
