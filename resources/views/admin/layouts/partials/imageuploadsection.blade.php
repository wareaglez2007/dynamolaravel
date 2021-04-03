@if (is_countable($images) && count($images) > 0)
    <div class="row">
        @foreach ($images as $img)

            <div class="col-md-2" style="margin-bottom: 5px">

                <div class="card">
                    <a href="{{ $img->id }}" id="{{ $img->id }}" title="/storage/uploads/thumbnails/{{ $img->file }}"
                        onclick="event.preventDefault();ShowImageEditOptions({{ $img->id }})">
                        <img src="/storage/uploads/thumbnails/{{ $img->file }}" class="card-img-top "
                            alt="/images/thumbs/{{ $img->file }}" />
                    </a>
                    <div class="card-body" style="border-top: solid 1px rgba(0, 0, 0, 0.125)">
                        <p class="card-title">{{ $img->file }}</p>
                        <p class="card-text">
                            <div class="col-sm-2">
                                <a href="" onclick="event.preventDefault();DeleteSelectedImage({{ $img->id }}, '{{ $img->file }}')">
                                <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
                        </p>
                    </div>
                </div>
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

    function DeleteSelectedImage(id,image_name){
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
            data:{
                id: id,
                image_name:image_name
            },
            success: function(data) {
                console.log(data.success);
                $("#ajaxactioncallimages").attr('class', "alert alert-success")
                $("#ajaxactioncallimages").html("<p>" + data.success + "</p>");
                $('#images_section').html(data.view);

            }, //end of success
            error: function(error) {

                $("#ajaxactioncallimages").attr('class', "alert alert-danger");
                $.each(error.responseJSON.errors, function(index, val) {
                    $("#ajaxactioncallimages").append("<p>" +val  + "</p>");
                    console.log(index, val);
                });

                console.log(error);


            } //end of error
        }); //end of ajax
    }

</script>
