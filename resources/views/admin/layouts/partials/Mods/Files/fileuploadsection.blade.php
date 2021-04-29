@if (is_countable($files) && count($files) > 0)
    <div class="row">
        @foreach ($files as $file)
            <div class="col-md-2">


                    <img src="{{ asset('storage/resource-images/' . $file->extension.".png") }}" width="45px" height="45px"/>

                    {{ $file->file_name }}


            </div>
        @endforeach
    </div>
@else
    <div class="col-md-12">
        <p>There are currently no files uploaded.</p>
    </div>
@endif
