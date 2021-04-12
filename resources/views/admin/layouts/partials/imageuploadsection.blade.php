@if (is_countable($images) && count($images) > 0)
    <div class="row" id="mod_images_section">
        @foreach ($images as $img)

            <div class="col-md-2" style="margin-bottom: 15px" id="uploadedimages">

                <div class="square">

                    <a href="{{ $img->id }}" id="{{ $img->id }}" data-toggle="modal"
                        data-target="#image_modal_{{ $img->id }}"
                        title="{{ asset('storage/thumbnails/' . $img->image_original_name) }}"
                        onclick="event.preventDefault();">
                        <img src="{{ asset('storage/thumbnails/' . $img->file) }}" @if ($img->image_width != $img->image_height) class="upload-img-thumbnail landscape"
@else
                        class="upload-img-thumbnail" @endif
                            alt="/images/thumbs/{{ $img->file }}" />
                    </a>
                </div>
                <a href=""
                    onclick="event.preventDefault();DeleteSelectedImage({{ $img->id }}, '{{ $img->file }}', {{ $images->currentPage() }}, {{ $images->count() }})">
                    <i class="bi bi-trash-fill text-danger"></i>
                </a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="image_modal_{{ $img->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel_{{ $img->id }}">Name:
                                {{ $img->image_original_name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!--image-->
                                    <img src="{{ asset('storage/' . $img->file) }}" class="img-thumbnail "
                                        class="upload-img-thumbnail" alt="/images/thumbs/{{ $img->file }}" />
                                    <!--link to image-->
                                    <small class="text-muted"><b>Link:
                                        </b>{{ asset('storage/' . $img->file) }}</small>
                                </div>
                                <div class="col-md-6">
                                    <!--Edit image properties-->
                                    <div class="form-group">
                                        <label for="">Title:</label>
                                        <input type="text" class="form-control"
                                            value="{{ $img->image_original_name }}" name="title_{{ $img->id }}"
                                            id="title_{{ $img->id }}" aria-describedby="helpId" placeholder="">

                                    </div>
                                    <div class="form-group">
                                        <label for="">Alt text:</label>
                                        <input type="text" class="form-control" name="alt_{{ $img->id }}"
                                            id="alt_{{ $img->id }}" aria-describedby="helpId"
                                            placeholder="SEO firendly name" value="{{ $img->image_alt_text }}">
                                        <small id="helpId" class="form-text text-muted">Alternative text</small>
                                    </div>
                                    <!-- height & width -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Width:</label>
                                                <input type="text" class="form-control"
                                                    name="width_{{ $img->id }}" id="width_{{ $img->id }}"
                                                    aria-describedby="helpId" placeholder=""
                                                    value="{{ $img->image_width }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Height:</label>
                                                <input type="text" class="form-control"
                                                    name="height_{{ $img->id }}" id="height_{{ $img->id }}"
                                                    aria-describedby="helpId" placeholder=""
                                                    value="{{ $img->image_height }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <form action="{{ URL::to('/admin/Images/updateimagesinfo') }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-primary"
                                    onclick="ShowImageEditOptions({{ $img->id }})">Save
                                    changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


    <div id="images_mod_pagination">
        {{ $images->withpath('/admin/Images/uploadimage/pagination') }}
    </div>




@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your file.
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    //This function will make sure pagination is handlled with Ajax in the background
    $(function() {
        $('#images_mod_pagination .pagination a').on('click', function(e) {
            e.preventDefault();
            //URL for the pagiantion
            var url = $(this).attr('href');
            getView(url);
        });

        function getView(url) {
            $.ajax({
                url: url,
                method: 'get'
            }).done(function(data) {
                $('#images_section').html(data.view);
            }).fail(function() {});
        }
    });

</script>
