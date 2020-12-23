@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('admin.layouts.app')
@section('content')
<div class="card" >
    <div class="card-header ">

        <ul class="nav nav-tabs card-header-tabs" id="backend-pages" role="tablist">
            <li class="nav-item">

                <a class="nav-link text-muted active" href="#published" role="tab"
                    aria-controls="published" aria-selected="true" id="pubcount"><i class="bi bi-eye"></i>
                    Published
                    ({{ $publishcount }}) </a>


            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="#draft" role="tab" aria-controls="draft"
                    aria-selected="false" id="draftcount"><i class="bi bi-eye-slash"></i>
                    Draft
                    ({{ $draftcount }})</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="#trashed" role="tab" aria-controls="trashed" aria-selected="false"
                    id="trashcount"><i class="bi bi-trash"></i>
                    Trashed
                    ({{ $trashed }})</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('admin.pages.create') }}">
                    <button class="btn btn-success"
                        style="height: 35px; line-height: 33px; padding: 0 25px; background: #1d9f3c; border-radius: 2px; margin-left:25px;">Add
                        new</button>
                </form>

            </li>

        </ul>

    </div>

        @include('admin.layouts.partials.page')
    </div>
@endsection
