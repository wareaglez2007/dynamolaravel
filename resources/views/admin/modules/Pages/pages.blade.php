@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('admin.layouts.app')
@section('content')
<div class="card" >
    <div class="card-header ">

        <ul class="nav nav-tabs card-header-tabs" id="backend-pages" role="tablist">
            <li class="nav-item">

                <a class="nav-link text-muted active" href="#published" role="tab"
                    aria-controls="published" aria-selected="true" id="pubcount"><i class="bi bi-eye"></i>
                    Published
                   <span id="pcount"> ({{ $publishcount }}) </span></a>


            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="#draft" role="tab" aria-controls="draft"
                    aria-selected="false" id="draftcount"><i class="bi bi-eye-slash"></i>
                    Draft
                    <span id="dcount">({{ $draftcount }})</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="#trashed" role="tab" aria-controls="trashed" aria-selected="false"
                    id="trashcount"><i class="bi bi-trash"></i>
                    Trashed
                   <span id="tcount"> ({{ $trashed }})</span></a>
            </li>
            <li class="nav-item">
                <form action="{{ route('admin.pages.create') }}">
                    <button class="btn btn-success"
                        style="height: 35px; line-height: 33px; padding: 0 25px; background: #1d9f3c; border-radius: 2px; margin-left:25px;">Add
                        new</button>
                </form>

            </li>

        </ul>

    </div>

        @include('admin.layouts.partials.page')
    </div>


    <script>
        //$('#backend-pages a').on('click', function(e) {
      //      e.preventDefault()
           // $(this).tab('show')
      //  })

    </script>
    <script type="text/javascript">



        $(function() {
           $('#pubcount').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
                //  $('#load a').css('color', '#dfecf6');
                //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

                var url = $(this).attr('href');
                getPublished(url);
                //window.history.pushState("", "", url);
            });

            //pubcount

            function getPublished(url) {
                $.ajax({
                    url: url
                }).done(function(data) {
                    //  console.log(data);
                    $('#some_ajax').html(data);
                }).fail(function() {
                    //Do some error
                });
            }
        });

        ///////////////////////NOW DRAFTS








        $(function() {
            $('#draftcount').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
                //  $('#load a').css('color', '#dfecf6');
                //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

                var url = '/admin/pages/getdraftpages';
                getPublished(url);
                // window.history.pushState("", "", url);
            });

            function getPublished(url) {
                $.ajax({
                    url: url
                }).done(function(data) {
                    //  console.log(data);
                    $('#some_ajax').html(data);
                }).fail(function() {
                    //Do some error
                });
            }
        });








        function GetAllPublishedPages() {
            $.get('/admin/pages/getpublishedtpages', function(getview) {
                console.log(getview);
               // $('#published').show();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]')
                        .attr(
                            'content')
                }
            });


        }

        function GetAllDraftPages() {
            $.get('/admin/pages/getdraftpages', function(getview) {
                console.log(getview);
             //   $('#published').hide();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]')
                        .attr(
                            'content')
                }
            });


        }

    </script>

        <!---Call AJAX FUNCTIONS HERE-->
        <script src="{{ asset('js/ajaxcalls.js') }}" defer></script>
@endsection
