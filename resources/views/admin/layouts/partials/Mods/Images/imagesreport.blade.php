<div class="card-header" id="upload_header">{{ $mod_name }}</div>


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


    <div id="image_report_section">
        @include('admin.layouts.partials.Mods.Images.imagesreporttable')
    </div>



    <!--Toast-->
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999999; right: 0; bottom: 0;" id="bottom_toast">
    </div>

</div>
