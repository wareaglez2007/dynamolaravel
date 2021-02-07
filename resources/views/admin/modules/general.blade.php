@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('admin.layouts.app')
@section('content')


    <div class="alert alert-success" id="ajaxactioncalls" style="display: none"></div>
    <div class="alert alert-danger" id="ajaxadangercalls" style="display: none"></div>



    <div class="card">
        <div class="card-header">{{ $mod_name }}</div>
        <div class="card-body">
            <div class="container">
                <div class="row justify-content-center" id='some_ajax'>
                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>

                        @endif
                        @if (request()->path() == 'admin/navigations')
                            @include('admin.modules.Navigations.navmod')
                        @endif
                        @if (request()->path() == 'admin/seo')
                            @include('admin.layouts.partials.seo')
                        @endif
                        @if (request()->path() == 'admin/social-media')
                            @include('admin.layouts.partials.socialmedia')
                        @endif
                        @if (request()->path() == 'admin/business-info')
                            @include('admin.layouts.partials.business')
                        @endif
                        @if (request()->path() == 'admin')
                            @include('admin.layouts.partials.dashboard')
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
