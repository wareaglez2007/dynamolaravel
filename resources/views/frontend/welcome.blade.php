@extends('frontend.layouts.header')
@section('content')
@foreach ($page_data as $data)

{{$data->uri}}
@dump($data)
@endforeach
<br/>
{{$page_children->title}}
@dump($page_children)

@endsection
