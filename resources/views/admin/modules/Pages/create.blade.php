@include('admin.layouts.partials.ckeditor')
@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ $section_name }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="alert alert-success" style="display:none"></div>

                        <div class="container">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <form id="cform">
                                @csrf
                                <div class="form-group">
                                    <label for="">Page Tile</label>
                                    <input type="text" name="title" id="page_title" class="form-control"
                                        placeholder="Page Tile" aria-describedby="helpId">
                                    <small id="helppagetitle" class="text-muted">This will be the name of your from i.e
                                        Home,
                                        About, etc.</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Page Subtitle</label>
                                    <input type="text" name="subtitle" id="page_subtitle" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <label for="">Page Parent</label>
                                    <select class="form-control" name="page_parent" id="page_parent">
                                        <option value="">None</option>
                                        <!---Select Parent page-->
                                        @foreach ($pageslist as $page)
                                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="">Slug</label>
                                    <input type="text" name="slug" id="page_slug" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId">
                                    <small id="helpIdSlug" class="text-muted">This will be used for the link in the front
                                        end.
                                        i.e. www.donain.com/about-us</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Page Owner</label>
                                    <input type="text" name="owner" id="page_owner" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <label for="">Page Content</label>
                                    <textarea name="description" id="editor" cols="30" rows="10"
                                        class="description_editor"></textarea>
                                    <script>
                                        CKEDITOR.replace('editor');

                                    </script>

                                </div>


                                <a href="" class="btn btn-primary" id="ajaxSubmit" onclick="CreateNewPagesAjax()">Create</a>
                                <a href="{{ route('admin.pages') }}" class="btn btn-dark">See all pages</a>
                            </form>
                            <!--Create New PAge AJAX CALL NEW -->
                            <script src="{{ asset('js/createpageajax.js') }}" defer></script>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content" id="modal_messages">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" id="ajax_messages">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="mtype">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
