
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




