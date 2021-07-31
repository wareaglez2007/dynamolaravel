@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('admin.layouts.app')
@section('content')


    <div class="alert alert-success" id="ajaxactioncalls" style="display: none"></div>
    <div class="alert alert-danger" id="ajaxadangercalls" style="display: none"></div>



    <div class="card" id="main_card">



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
        <!-- Navigation Manager (needs work) -->
        @if (request()->path() == 'admin/navigations')
            @include('admin.modules.Navigations.navmod')
        @endif
        <!-- SEO manager (needs work) -->
        @if (request()->path() == 'admin/seo')
            @include('admin.layouts.partials.seo')
        @endif
        <!-- Social Media Management (needs work) -->
        @if (request()->path() == 'admin/social-media')
            @include('admin.layouts.partials.socialmedia')
        @endif
        <!-- Business Information (needs work) -->
        @if (request()->path() == 'admin/business-info')
            @include('admin.layouts.partials.business')
        @endif
        <!-- Business Information (needs work) -->
        @if (request()->path() == 'admin/employees')
            @include('admin.layouts.partials.Mods.Employees.employees')
        @endif
        <!-- Main Dashboard (after login) (needs work) -->
        @if (request()->path() == 'admin')
            @include('admin.layouts.partials.dashboard')
        @endif
        <!-- Forms (needs work) -->
        @if (request()->path() == 'admin/forms')
            @include('admin.layouts.partials.forms')
        @endif
        <!-- Images -->
        @if (request()->path() == 'admin/Images/uploadimage')
            @include('admin.layouts.partials.Mods.Images.uploadimages')
        @endif
        <!-- Image page relation report (what image is assigned to which page) -->
        @if (request()->path() == 'admin/Images/uploadimagereport')
            @include('admin.layouts.partials.Mods.Images.imagesreport')
        @endif
        <!-- Files -->
        @if (request()->path() == 'admin/Files/managefiles')
            @include('admin.layouts.partials.Mods.Files.uploadfiles')
        @endif
        <!-- Files page relation report (what file is assigned to which page) -->
        @if (request()->path() == 'admin/Files/managefilesreport')
            @include('admin.layouts.partials.Mods.Files.filesreport')
        @endif

    </div>

@endsection
