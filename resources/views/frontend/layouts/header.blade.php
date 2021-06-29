<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.front_end_name') }}</title>
    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
          <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


  
   <!-- <link href="{{ asset('css/navigation.css') }}" rel="stylesheet">-->

    <!-- Styles -->
  
</head>

<body>
    <!--FIXED TOP SECTION-->


    @yield('content')



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
    @if (is_countable($files->fileforpages) && count($files->fileforpages) > 0)
        @foreach ($files->fileforpages as $file)
            @if ($file->extension == 'js')
                <script src="{{ asset(substr($file->storage_path, 1)) }}"></script>

            @endif
        @endforeach
    @else

    @endif

</body>

</html>
