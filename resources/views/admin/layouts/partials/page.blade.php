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

            @if (request()->path() == 'admin/pages')
                @include('admin.layouts.partials.publishedpage')
            @endif

            @if (request()->path() == 'admin/pages/drafts')
                @include('admin.layouts.partials.draftpages')
            @endif

            @if (request()->path() == 'admin/pages/trashed')
                @include('admin.layouts.partials.trashedpages')
            @endif




        </div>
    </div>
</div>
