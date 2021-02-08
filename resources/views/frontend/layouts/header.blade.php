<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    @yield('head')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navigation.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        /* Show it is fixed to the top */
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .navbar {
            margin-bottom: 20px;
        }

    </style>
</head>

<body>
    <!--FIXED TOP SECTION-->
    <header>
        <nav id="navbar_top" class="navbar navbar-expand-lg fixed-top  navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" aria-expanded="true" aria-label="Toggle navigation"
                data-trigger="#my_offcanvas1">
                <span class="navbar-toggler-icon"></span>
            </button>

            </div> <!-- container.// -->
        </nav>
    </header>
    <!--END OF FIXED TOP SECTION-->
    <!--Navigation-->
    @include('frontend.layouts.nav')

    <main class="container">

        @yield('content')

    </main>

    <script>
        $("[data-trigger]").on("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var offcanvas_id = $(this).attr('data-trigger');
            $(offcanvas_id).toggleClass("show");
            $('body').toggleClass("offcanvas-active");
            $(".screen-overlay").toggleClass("show");
        });

        $(".btn-close, .screen-overlay").click(function(e) {
            $(".screen-overlay").removeClass("show");
            $(".offcanvas").removeClass("show");
            $("body").removeClass("offcanvas-active");
        });

    </script>

</body>

</html>
