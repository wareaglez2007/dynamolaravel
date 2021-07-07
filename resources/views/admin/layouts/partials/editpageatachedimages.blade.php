@if (is_countable($editview->imageforpages) && count($editview->imageforpages) > 0)
    <div class="row">

        @foreach ($editview->imageforpages as $img)

            <div class="col-md-1" style="margin-bottom: 15px" id="uploadedimages">

                <div class="small_square">

                    <a href="{{ $img->id }}" id="{{ $img->id }}" data-toggle="modal"
                        data-target="#attached_image_modal_{{ $img->id }}"
                        title="{{ asset('storage/thumbnails/' . $img->image_original_name) }}"
                        onclick="event.preventDefault();">
                    <img src="{{ asset('storage/' . $img->file) }}" @if ($img->image_width != $img->image_height) class="img-fluid upload-img-thumbnail landscape" @else
                            class="img-fluid upload-img-thumbnail" @endif
                            alt="/images/{{ $img->file }}" id="{{ $img->id }}" />
                    </a>
                </div>
            </div>

            <!-- Modal for attached images pop up -->
            <div class="modal fade" id="attached_image_modal_{{ $img->id }}" tabindex="-1"
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
                                                    value="{{ $img->image_width }}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Height:</label>
                                                <input type="text" class="form-control"
                                                    name="height_{{ $img->id }}" id="height_{{ $img->id }}"
                                                    aria-describedby="helpId" placeholder=""
                                                    value="{{ $img->image_height }}" disabled>
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
                                    onclick="EditAttachedImageprops({{ $img->id }})">Save
                                    changes</button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="DetachImagesFromPage({{ $editview->id }},{{ $img->id }});"><i
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

