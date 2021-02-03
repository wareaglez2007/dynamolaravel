@extends('frontend.layouts.header')
@section('content')
@foreach ($page_data as $data)

{{$data->uri}}
@endforeach

{{$page_children->title}}


@endsection
