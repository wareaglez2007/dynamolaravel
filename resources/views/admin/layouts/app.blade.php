<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('head')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboardside.css') }}" rel="stylesheet">
    @yield('styles')
    <style>


    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
                data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <input class="form-control form-control-dark w-50" type="text" placeholder="Search" aria-label="Search">
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.home') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-house-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                        <path fill-rule="evenodd"
                                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                                    </svg>&nbsp;
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">



                                <div class="accordion" id="accordionExample">

                                    <a class="nav-link" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="false" aria-controls="collapseOne" href="#">
                                        <i class="bi bi-file-richtext"></i>&nbsp;
                                        Pages Manager
                                    </a>

                                    <div class="collapse hide" id="collapseOne" class="" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <a href="{{ route('admin.pages') }}" class="list-group-item nav-link"
                                            id="pages_manager_ajax">Edit
                                            Pages</a>
                                        <a href="{{ route('admin.pages.create') }}"
                                            class="list-group-item nav-link">Create New</a>
                                        <a href="{{ route('admin.pages.tree') }}"
                                            class="list-group-item nav-link">Page
                                            Tree</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.navigations') }}">
                                    <i class="bi bi-signpost-2"></i>&nbsp;
                                    Navigations Manager
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.forms') }}">
                                    <i class="bi bi-input-cursor-text"></i>&nbsp;
                                    Forms Manager
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.seo') }}">
                                    <i class="bi bi-graph-up"></i>&nbsp;
                                    SEO Manager
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.social') }}">
                                    <i class="bi bi-facebook"></i>&nbsp;
                                    Social Media Manager
                                </a>
                            </li>
                            <li class="nav-item">

                                <div class="accordion" id="accordionmenutwo">

                                    <a class="nav-link" data-toggle="collapse" data-target="#collapsetwo"
                                        aria-expanded="false" aria-controls="collapseOne" href="#">
                                        <i class="bi bi-images"></i>&nbsp;
                                        Media Manager
                                    </a>
                                    <div class="collapse hide" id="collapsetwo" class="" aria-labelledby="headingTwo"
                                        data-parent="#accordionmenutwo">
                                        <a href="{{ route('admin.images.upload') }}" class="list-group-item nav-link"
                                            id="image_page">

                                            Upload Images</a>

                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.business') }}">
                                    <i class="bi bi-shop"></i>&nbsp;
                                    Business Info Manager
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-file-text"></i>&nbsp;
                                    Posts Manager
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-chat-square-text"></i>&nbsp;
                                    Comments Manager
                                </a>
                            </li>
                        </ul>

                        <h6
                            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Accout Settings</span>
                            <a class="d-flex align-items-center text-muted" href="#" aria-label="Account Settings">
                                <i class="bi bi-gear-fill"></i>
                            </a>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
                                    <i class="bi bi-person-circle"></i>&nbsp;
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
                                    <i class="bi bi-person-plus-fill"></i>&nbsp;
                                    Add New User

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
                                    <i class="bi bi-person-lines-fill"></i>&nbsp;
                                    Manage Users
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="table-responsive">
                        <main class="py-4" id="ajax_main_container">
                            @yield('content')
                        </main>
                    </div>
                </main>
            </div>
        </div>

    </div>


</body>
