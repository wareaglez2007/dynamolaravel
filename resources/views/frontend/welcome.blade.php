@extends('frontend.layouts.header')

@section('content')

    @if (request()->path() != '/')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Home</li>
                @for ($i = 0; $i < count($bread_crumbs); $i++)
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ $bread_crumbs[$i]->slug->uri }}">{{ $bread_crumbs[$i]->title }}</a>
                    </li>
                @endfor

            </ol>
        </nav>
    @endif




    @foreach ($page_data as $data)

        {{ $data->uri }}


    @endforeach
    <br />
    {{ $page_children->title }}


@endsection
