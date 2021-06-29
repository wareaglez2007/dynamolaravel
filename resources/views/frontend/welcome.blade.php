@extends('frontend.layouts.header')
@section('head')
    @if (is_countable($files->fileforpages) && count($files->fileforpages) > 0)
        @foreach ($files->fileforpages as $file)
            @if ($file->extension == 'css')
                <link rel="stylesheet" href=" {{ asset(substr($file->storage_path, 1)) }}">

            @endif
        @endforeach
    @else

    @endif
@endsection
@section('content')
    <!--Breadcrumb-->
    @if (request()->path() != '/')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="/" title="home">
                        <i class="bi bi-house-fill"></i>
                    </a>
                </li>
                @foreach ($bread_crumbs as $k => $bc)

                    @if ($k == count($bread_crumbs) - 1)
                        <li class="breadcrumb-item active" aria-current="page" title="{{ $bc->title }}">
                            {{ $bc->title }}
                        </li>
                    @else
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ $bc->slug->uri }}" title="{{ $bc->title }}">{{ $bc->title }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    @endif
    <!--End of Breadcrumb-->



    @foreach ($page_data as $data)

        {{ $data->uri }}


    @endforeach
    <br />
    {!! $page_children->content !!}


@endsection
