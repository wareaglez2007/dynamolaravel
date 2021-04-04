@if (is_countable($images) && count($images) > 0)
    <div class="row">
        @foreach ($images as $img)

            <div class="col-md-2" style="margin-bottom: 15px" id="uploadedimages">

                <div class="square">

                    <a href="{{ $img->id }}" id="{{ $img->id }}"
                        title="{{ asset('storage/thumbnails/' . $img->image_original_name) }}"
                        onclick="event.preventDefault();ShowImageEditOptions({{ $img->id }})">
                        <img src="{{ asset('storage/thumbnails/' . $img->file) }}" @if ($img->image_width != $img->image_height) class="upload-img-thumbnail landscape"
                    @else
                        class="upload-img-thumbnail" @endif
                            alt="/images/thumbs/{{ $img->file }}" />
                    </a>
                </div>
                <a href=""
                    onclick="event.preventDefault();DeleteSelectedImage({{ $img->id }}, '{{ $img->file }}')">
                    <i class="bi bi-trash-fill text-danger"></i>
                </a>
                <p style="font-size:10px;">Name: {{ $img->image_original_name }} Width:{{ $img->image_width }} Height:
                    {{ $img->image_height }} </p>



            </div>
        @endforeach
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



<style>
    .square {
        position: relative;
        width: 140px;
        height: 140px;
        overflow: hidden;
    }

    #uploadedimages img {
        position: absolute !important;
        width: 100%;
        height: auto;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
    }

    #uploadedimages img.landscape {
        height: 100%;
        width: auto;
    }

    #uploadedimages .upload-img-thumbnail {
        padding: 0.25rem;
        background-color: #f8fafc;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        height: auto;
    }

</style>





<!--On select lets do-->
<!--1 delete-->

<script>
    function ShowImageEditOptions(id) {
        //Options:

        //Edit title
        //Edit size
        //Edit alt text
        //Delete image
    }

    function DeleteSelectedImage(id, image_name) {
        //When user selects the open button call ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                        'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }

        }); //End of ajax setup
        $.ajax({
            url: "/admin/Images/deleteselectedimage",
            method: "post",
            cache: false,
            data: {
                id: id,
                image_name: image_name
            },
            success: function(data) {
                //console.log(data.success);
                $("#ajaxactioncallimages").attr('class', "alert alert-success")
                $("#ajaxactioncallimages #s_message").html('<img src="/storage/ajax-loader.gif"/>' + data.success);
                $('#images_section').html(data.view);
              //  $('#ajaxactioncallimages').fadeOut(2500);

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
    }

</script>
