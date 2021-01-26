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

    @if (is_countable($images) && count($images) > 0)
        <div class="row">
            <div class="col-md-8">
                <strong>Original Image:</strong>
            </div>
            <div class="col-md-4">
                <strong>Thumbnail Image:</strong>
            </div>
            @foreach ($images as $img)
                <div class="col-md-8">
                    <img src="/images/{{ $img->file }}" style="width:400px" />
                </div>
                <div class="col-md-4">
                    <img src="/images/thumbs/{{ $img->file }}" />
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
    <form action="{{ URL::to('/admin/Images/uploadimage') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <input type="file" name="upload[]" multiple>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-info">Upload</button>
            </div>
        </div>
    </form>
</div>
