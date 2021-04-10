@if (is_countable($images) && count($images) > 0)
    <div class="row">
        @foreach ($images as $img)

            <div class="col-md-2" style="margin-bottom: 15px" id="uploadedimages">

                <div class="square">

                    <a href="{{ $img->id }}" id="{{ $img->id }}" data-toggle="modal"
                        data-target="#image_modal_{{ $img->id }}"
                        title="{{ asset('storage/thumbnails/' . $img->image_original_name) }}"
                        onclick="event.preventDefault();">
                    <img src="{{ asset('storage/thumbnails/' . $img->file) }}" @if ($img->image_width != $img->image_height) class="upload-img-thumbnail landscape" @else
                        class="upload-img-thumbnail" @endif
                            alt="/images/thumbs/{{ $img->file }}" />
                    </a>
                </div>
            </div>


        @endforeach
    </div>
@endif
