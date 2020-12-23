
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
                @if (request()->path() == 'admin/pages/getpublishedtpages')
                    @include('admin.layouts.partials.publishedpage')
                @else
                    @if (request()->path() == 'admin/pages/getdraftpages')
                        @if ($draftcount > 0)
                            @include('admin.layouts.partials.draftpages')
                        @else
                            {{ 'There are no draft items here currently!' }}
                        @endif

                    @endif
                @endif

            </div>
        </div>
    </div>
    <!---Call AJAX FUNCTIONS HERE-->
    <script src="{{ asset('js/ajaxcalls.js') }}" defer></script>



    <script>
        //$('#backend-pages a').on('click', function(e) {
      //      e.preventDefault()
           // $(this).tab('show')
      //  })

    </script>
    <script type="text/javascript">
        $(function() {
            $('#published .pagination a').on('click', function(e) {
                e.preventDefault();

                //  $('#load a').css('color', '#dfecf6');
                //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

                var url = $(this).attr('href');
                getPublished(url);
                window.history.pushState("", "", url);
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
            $('#draft_pagination .pagination a').on('click', function(e) {
                e.preventDefault();

                //  $('#load a').css('color', '#dfecf6');
                //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

                var url = $(this).attr('href');
                getPublished(url);
                window.history.pushState("", "", url);
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


