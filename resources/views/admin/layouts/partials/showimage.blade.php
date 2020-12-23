@if (session('status'))
    <div class="alert alert-success" id="success_ajax" role="alert">
        {{ session('status') }}
    </div>
@endif

@if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@foreach ($images as $message)
    <div id="ajax_success{{ $message->id }}">
    </div>
    <div id="ajax_errors{{ $message->id }}">
    </div>
@endforeach
<div class="card">
    <div class="card-header ">

        <ul class="nav nav-tabs card-header-tabs">

            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Upload Media</a>

            </li>
        </ul>
    </div>
    <div class="card-header">
        <div style="text-align: center">
            <form enctype="multipart/form-data" id="myForm">
                @csrf
                <div class="form-group">
                    <label for="image" class="custom-upload-btn" id="btnFileUpload">Add new</label>
                    <input type="file" class="form-control-file" name="image" id="image" placeholder=""
                        aria-describedby="fileHelpId" style="display: none">
                    <small id="spnFilePath" class="form-text text-muted"></small>
                </div>
            </form>
        </div>



        <ul class="nav nav-tabs card-header-tabs" id="backend-pages" role="tablist">
            <li class="nav-item">

                <a class="nav-link disabled" href="" role="tab" aria-controls="published" aria-selected="true">Total:
                    <span id="imagecount">({{ $totalcount }})</span> </a>
            </li>
        </ul>



    </div>

    <div class="card-body">

        <div class="col-md-12">
            <div class="row">
                <!---IMAGE SECTION-->
                <div class="col-md-8">
                    <div class="row" id="images_row">
                        @if (count($images) != 0)
                            @foreach ($images as $image)
                                <div class="col-lg-3" id="image{{ $image->id }}" data-image-id="{{ $image->id }}">
                                    <div class="card custom-card">
                                        <!---If link click change class--->
                                        <a href="javascript:void(0)" class="" id="imagelink{{ $image->id }}"
                                            onclick="ImageInfoForm({{ $image->id }})">
                                            <img src="{{ asset($image->path_to . $image->image_name) }}"
                                                class="card-img-top" />

                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else

                            <p id="noimageyet">No Images yet</p>
                        @endif
                    </div>
                </div>
                <!-----Image INFORMATION SECTION-->
                <div class="col-md-4">
                    @if (session()->has('update_image_message'))
                        <div class="alert alert-success" id="image_update_message">
                            {{ session()->get('update_image_message') }}
                        </div>
                    @endif
                    <div id="ajax_update_success"></div>


                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">

                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Image
                                        Information:</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div id="no_image_message"></div>
                            <div id="image_info_capsul">
                                <div class="card-header">
                                    <a href="javascript:void(0)" onclick="" id="delimage" class="text-muted danger">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z" />
                                        </svg> Delete Image
                                    </a>
                                </div>
                                <!---When an image link is clicked we should show alt name text filed, tags, caption, and small image thumnail--->
                                <form id="anyimage" action="{{ route('Backend.Modules.updateimage') }}" method="POST">
                                    <div class="form-group">
                                        <label for="">Image name</label>
                                        <input type="text" name="imagename" id="imagename" class="form-control"
                                            placeholder="" aria-describedby="helpId">

                                    </div>
                                    <div class="form-group">
                                        <label for="">Alt text</label>
                                        <input type="text" name="alttext" id="alttext" class="form-control"
                                            placeholder="" aria-describedby="helpId">

                                    </div>
                                    <div class="form-group">
                                        <label for="">Caption</label>
                                        <input type="text" name="caption" id="imagecaption" class="form-control"
                                            placeholder="" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">Image Captions</small>
                                    </div>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" id="update_image_id" value="">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-success" id="updatebutton"
                                            onclick="">Update</a>
                                        <a href="javascript:void(0)" class="btn btn-secondary" id="addimagetopage"
                                            onclick="">Add to Page</a>
                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
