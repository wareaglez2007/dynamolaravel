@if (is_countable($images) && count($images) > 0)
    <div class="row" id="images_div">

        @foreach ($images as $img)

            <div class="col-md-2" style="margin-bottom: 15px" id="uploadedimages">

                <div class="square">

                    <a href="{{ $img->id }}" id="{{ $img->id }}" data-toggle="modal"
                        data-target="#image_modal_{{ $img->id }}"
                        title="{{ asset('storage/thumbnails/' . $img->image_original_name) }}"
                        onclick="event.preventDefault();">
                    <img src="{{ asset('storage/thumbnails/' . $img->file) }}" @if ($img->image_width != $img->image_height) class="upload-img-thumbnail landscape" @else
                            class="upload-img-thumbnail" @endif
                            alt="/images/thumbs/{{ $img->file }}" id="{{ $img->id }}" />
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
<div id="editpage_pagination">
    {{ $images->withpath('/admin/pages/editpagepaginations/' . $editview->id) }}
</div>
<style>
    span.imgCheckbox0 {
        position: inherit !important;

    }

</style>
<script src="{{ asset('imgCheckbox-master/jquery.imgcheckbox.js') }}"></script>
<script>
    //This function will make sure pagination is handlled with Ajax in the background
    $(function() {
        $('#editpage_pagination .pagination a').on('click', function(e) {
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
                $('#images_modal').html(data.view);
            }).fail(function() {});
        }
    });

    $("#images_div img").imgCheckbox({
        "graySelected": true,
        "scaleSelected": true,
        onload: function() {
            // Do something fantastic!
        },
        onclick: function(el) {
            var isChecked = el.hasClass("imgChked"),
                imgEl = el.children()[0]; // the img element
            
           // console.log(imgEl.id + " is now " + (isChecked ? "checked" : "not-checked") + "!");
            var page_id = $("#page_id_image").val();
            if (isChecked) {
                var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "image_id_" + imgEl.id)
                    .attr("id", "image_id_" + imgEl.id)
                    .val(imgEl.id);
                $('#image_page_attachment').append(input);
            } else {
                $("#image_id_" + imgEl.id).remove();
            }

        }
    });

</script>
