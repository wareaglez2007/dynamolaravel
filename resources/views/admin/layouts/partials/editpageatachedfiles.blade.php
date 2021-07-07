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
                                    onclick="DetachFileFromPage({{ $editview->id }},{{ $file->id }});"><i
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
        <p>There are currently no files attached to this page.</p>
    </div>
@endif

