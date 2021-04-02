@if (is_countable($images) && count($images) > 0)
    <div class="row">
        @foreach ($images as $img)

            <div class="col-md-2" style="margin-bottom: 5px">

                <div class="card">
                    <a href="{{ $img->id }}" id="{{ $img->id }}" title="/images/thumbs/{{ $img->file }}"
                        onclick="event.preventDefault();ShowImageEditOptions({{ $img->id }})">
                        <img src="/images/thumbs/{{ $img->file }}" class="card-img-top "
                            alt="/images/thumbs/{{ $img->file }}" />
                    </a>
                    <div class="card-body" style="border-top: solid 1px rgba(0, 0, 0, 0.125)">
                        <p class="card-title">{{ $img->file }}</p>
                        <p class="card-text">
                            <div class="col-sm-2">
                                <i class="bi bi-trash-fill"></i>
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

</script>
