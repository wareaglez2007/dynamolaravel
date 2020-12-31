@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('admin.layouts.app')
@section('content')


    <div class="alert alert-success" id="ajaxactioncalls" style="display: none"></div>
    <div class="alert alert-danger" id="ajaxadangercalls" style="display: none"></div>



    <div class="card">
        <div class="card-header ">

            <ul class="nav nav-tabs card-header-tabs" id="backend-pages" role="tablist">
                <li class="nav-item">

                    <a class="nav-link text-muted active" href="#published" role="tab" aria-controls="published"
                        aria-selected="true" id="pubcount"><i class="bi bi-folder-check"></i>
                        Published
                        <span id="pcount"> ({{ $publishcount }}) </span></a>


                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#draft" role="tab" aria-controls="draft" aria-selected="false"
                        id="draftcount"><i class="bi bi-folder-plus"></i>
                        Draft
                        <span id="dcount">({{ $draftcount }})</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#trashed" role="tab" aria-controls="trashed" aria-selected="false"
                        id="trashcount"><i class="bi bi-trash"></i>
                        Trashed
                        <span id="tcount"> ({{ $trashed }})</span></a>
                </li>


            </ul>

        </div>

        @include('admin.layouts.partials.page')
        <div class="card-footer">

        </div>
    </div>

    <script type="text/javascript">

    </script>

    <!---Call AJAX FUNCTIONS HERE-->
    <script src="{{ asset('js/ajaxcalls.js') }}" defer></script>
@endsection
