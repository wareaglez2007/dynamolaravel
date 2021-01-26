<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Upload Images') }}</div>
                <div class="container">
                    <div class="row justify-content-center" id='image_ajax'>
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

                            @if (request()->path() == 'admin/Images/uploadimage')
                                @include('admin.layouts.partials.uploadimages')
                            @endif




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
