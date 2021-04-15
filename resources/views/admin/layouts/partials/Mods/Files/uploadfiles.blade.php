<div class="card-header" id="upload_header">{{ $mod_name }}</div>
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


                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="upload[]" id="chosen_images" multiple>
                    <label class="custom-file-label" for="customFile">Choose file(s)</label>
                  </div>

            </div>

            <div class="col-md-4">

            </div>
        </div>
    </form>



</div>
<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999999; right: 0; bottom: 0;" id="bottom_toast">
</div>
 <!--Upload Images, Edit, Delete AJAX CALL NEW -->
 <script src="{{ asset('js/uploadimagesajax.js') }}" defer></script>

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
        @include('admin.layouts.partials.Mods.Files.fileuploadsection')
    </div>

</div>

