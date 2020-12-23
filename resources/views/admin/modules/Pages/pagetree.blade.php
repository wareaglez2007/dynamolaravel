@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pages Tree</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="alert alert-success" style="display:none"></div>

                        <div class="container">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <ul>
                                @if (count($items) > 0)
                                    @foreach ($items as $item)
                                        <li>{{ $item->title }}</li>
                                        <ul>
                                            @if (count($item->childItems))
                                                @foreach ($item->childItems as $childItems)
                                                    @include('admin.layouts.partials.sub_items', ['sub_items' => $childItems])
                                                @endforeach
                                            @endif
                                        </ul>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
