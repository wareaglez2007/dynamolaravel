@if (is_countable($files) && count($files) > 0)
    <div class="row">
        @foreach ($files as $file)
        <div class="col-md-2">
            @if ($file->extension == "pdf")

            <i class="bi bi-file-earmark-ppt h3"></i>
            {{$file->file_name}}
            @endif
            @if ($file->extension == "txt")

            <i class="bi bi-file-text h3"></i>
            {{$file->file_name}}
            @endif
            @if ($file->extension == "html")

            <i class="bi bi-file-earmark-code h3"></i>
            {{$file->file_name}}
            @endif
            @if ($file->extension == "css")

            <i class="bi bi-file-earmark-code-fill h3"></i>
            {{$file->file_name}}
            @endif
            @if ($file->extension == "js")

            <i class="bi bi-file-code h3"></i>
            {{$file->file_name}}
            @endif

        </div>
        @endforeach
    </div>
@endif
