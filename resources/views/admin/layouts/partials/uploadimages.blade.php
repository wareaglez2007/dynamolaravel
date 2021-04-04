<div class="card-header">{{ $mod_name }}</div>
<div class="card-header">


    <div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="ajaxactioncallimages">
        <span id="s_message"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="alert alert-danger d-none alert-dismissible fade show" role="alert" id="ajaxadangercallimages">
        <span id="e_message"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form action="{{ URL::to('/admin/Images/uploadimage') }}" method="POST" enctype="multipart/form-data"
        id="upload_images_form">
        @csrf
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <input type="file" name="upload[]" id="chosen_images" multiple>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </form>

</div>
<script>
    $("#upload_images_form").on("change", function() {
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
            url: "/admin/Images/uploadimage",
            method: "post",
            cache: false,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                //  console.log(data.success);
                $("#ajaxactioncallimages").attr('class', "alert alert-success")
                $("#ajaxactioncallimages #s_message").html('<img src="/storage/ajax-loader.gif">' + data
                    .success);
                $('#images_section').html(data.view);
                // $('#ajaxactioncallimages').fadeOut(2500);
            }, //end of success
            error: function(error) {

                $("#ajaxactioncallimages").attr('class', "alert alert-danger");
                $.each(error.responseJSON.errors, function(index, val) {
                    $("#ajaxactioncallimages #e_message").html(
                        "<img src='/storage/ajax-loader-red.gif'>" + val);
                    //   $('#ajaxactioncallimages').fadeOut(2500);
                    //console.log(index, val);
                });

                console.log(error);


            } //end of error
        }); //end of ajax

    }); //End of on change

    function getPublished(url) {
        $.ajax({
            url: url
        }).done(function(data) {

            // $('#images_section').html(data.view);
        }).fail(function() {

        });
    }

</script>
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <!--Container for images content-->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif




    <!--Show media section-->
    <div id="images_section">
        @include('admin.layouts.partials.imageuploadsection')
    </div>

</div>
