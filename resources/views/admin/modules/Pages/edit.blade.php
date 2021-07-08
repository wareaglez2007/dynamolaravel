@include('admin.layouts.partials.ckeditor')
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">{{ __('Edit Page') }}</div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <b>Page Status:</b>

                                <form action="" method="POST" class="page-stat-form">

                                    @csrf
                                    <label class="switch">

                                        <input type="checkbox" @if ($editview->active == 1) checked @endif data-toggle="toggle" data-on="Yes"
                                            data-off="No" id="page_stat">

                                        <span class="slider round"></span>
                                    </label>
                                    <input type="hidden" name="page_id" id="page_id" value="{{ $editview->id }}" />
                                </form>



                            </div>

                        </div>

                    </div>
                    <!--Edit the slug-->
                    <div class="card-header">
                        <p>Permalink</p>
                        @if ($editview->slug->slug != null)
                            <div class="col-md-6">
                                <form action="" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ config('app.url') }}{{ $permalink }}/"
                                        id="site_url" />
                                    <input type="hidden" value="{{ $editview->slug->slug }}" id="hidden_page_slug" />
                                    <input type="hidden" value="{{ $editview->id }}" id="edit_url_pg_id" />
                                    <input type="hidden" value="{{ $editview->parent_id }}" id="edit_url_parent" />
                                    <input type="hidden" value="{{ config('app.url') }}" id="page_base_url" />
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="inputGroup-sizing-sm">{{ config('app.url') }}{{ $permalink }}/</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input"
                                            id="slug_input_section" aria-describedby="inputGroup-sizing-sm"
                                            value="{{ $editview->slug->slug }}" disabled onkeyup="CheckUserSlugInput()">
                                        <!--Unlock button-->
                                        <button type="button" class="form-control btn btn-outline-secondary"
                                            id="do_edit_slug" style="max-width: 60px;"
                                            onclick="event.preventDefault();EnableSlugEdit();"><i
                                                class="bi bi-lock"></i></button>
                                        <!--Save Buton-->
                                        <button type="button" class="form-control btn btn-success d-none"
                                            id="save_edit_slug" style="max-width: 60px;"
                                            onclick="event.preventDefault();SaveSlugChanges({{ $editview->id }}, {{ $editview->parent_id }})">Save</button>

                                    </div>
                                    <small id="helpIdSlug" class="text-muted">This will be used for the link in the front
                                        end.
                                        i.e. www.donain.com/about-us</small>
                                    <br />
                                    <a href="{{ config('app.url') }}{{ $editview->slug->uri }}" id="page_link"
                                        class="text-muted" target="new">
                                        {{ config('app.url') }}{{ $editview->slug->uri }}</a>

                                </form>
                            </div>
                        @else
                            <a href="{{ config('app.url') }}{{ $permalink }}/" id="page_link" class="text-muted">
                                {{ config('app.url') }}{{ $permalink }}/</a>
                        @endif

                    </div>

                    <!-- Main page information section-->

                    <!--Card body 1 -->
                    <div class="card-body" style="border-right: 1px solid rgba(0, 0, 0, 0.125)">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="container">
                            <form action="/admin/pages/update" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Page Tile</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Page Tile"
                                        aria-describedby="helpId" value="{{ $editview->title }}">
                                    <small id="helpId" class="text-muted">This will be the name of your from i.e
                                        Home,
                                        About, etc.</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Page Subtitle</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId"
                                        value="{{ $editview->subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Page Parent</label>
                                    <select class="form-control" name="page_parent" id="page_parent">
                                        <option value="">None</option>
                                        @foreach ($pages as $item)


                                            @if ($editview->parent_id == $item->id)
                                                {{ $selected = 'selected' }}

                                                <option value="{{ $item->id }}" {{ $selected }}>
                                                    {{ $item->title }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->title }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Page URI"
                                        aria-describedby="helpId" @if ($editview->slug != null) value="{{ $editview->slug->slug }}"
                                @else
                                                                                                                                                                                                                                                                                                                                                    value="" @endif>
                                    <small id="helpId" class="text-muted">This will be used for the link in the
                                        front
                                        end. i.e. www.donain.com/about-us</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Page Owner</label>
                                    <input type="text" name="owner" id="owner" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId"
                                        value="{{ $editview->owner }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Created Date</label>
                                    <input type="text" name="created_at" id="" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId"
                                        value="{{ $editview->created_at }}" disabled>
                                </div>
                                @if (null !== $editview->deleted_at)
                                    <div class="form-group">
                                        <label for="">Deleted Date</label>
                                        <input type="text" name="deleted_at" id="" class="form-control"
                                            placeholder="Page Subtitle" aria-describedby="helpId"
                                            value="{{ $editview->deleted_at }}" disabled>
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label for="">Publish Start Date</label>
                                    <input type="datetime" name="publish_start_date" id="" class="form-control"
                                        placeholder="Publish Start Date" aria-describedby="helpId"
                                        value="{{ $editview->created_at }}">
                                </div>


                                <!--Components section RS 03-26-2021-->


                                <p>Add Sections:</p>
                                <!--Questions for components-->
                                <!--Section 1 q1 -->
                                <div class="form-group">
                                    <label for="" class="form-label">Is this a homepage?</label>
                                    <input type="checkbox" name="is_homepage" id="is_homepage" class=""
                                        aria-describedby="helpId" @if ($editview->is_homepage == 1) value="1" checked
                                        @else
                                                                                                                                                                                                                                                                                                                value="null" @endif @if ($homepageCount != 0 && $editview->is_homepage != 1)
                                    disabled
                                    @endif
                                    >
                                    <input type="hidden" name="page_id" id="page_id" value="{{ $editview->id }}" />
                                    <span id="homepage_message"></span>
                                </div>
                                <!--section1 q2-->
                                <div class="form-group">
                                    <label for="" class="form-label">Does the page need a carousel?</label>
                                    <input type="checkbox" name="need_carousel" id="need_carousel" class=""
                                        aria-describedby="helpId" value="1">
                                </div>

                                <!-- END Components section---->

                                <!---Images Section-->
                                <!--TODO: selecting images first from media manager -->
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                        data-target="#showeditpageimages">Select Images for
                                        this page</button>
                                </div>
                                <!--Images Modal-->
                                <!-- Modal -->
                                <div class="modal fade" id="showeditpageimages" data-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Media (images)</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    <input type="hidden" value="{{ $editview->id }}"
                                                        id="page_id_images" />
                                                    <input type="hidden" id="pagination_page"
                                                        value="{{ $images->nextPageUrl() }}" />
                                                </button>
                                            </div>
                                            <div class="modal-body" id="images_modal">

                                                @include('admin.layouts.partials.showpageimages')

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="attach_image_to_page"><i
                                                        class="bi bi-paperclip"></i>&nbsp;Attach</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Attached Images section-->
                                <div id="attached_images">
                                    @include('admin.layouts.partials.editpageatachedimages')
                                </div>
                                <!--Attached Images section-->
                                <!--End Images model-->
                                <!---END IMAGES SECTION-->





                                <!--Files selection Section-->

                                <!---Files Section-->
                                <!--TODO: selecting files first from files manager -->
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                        data-target="#showeditpagefiles">Select Files for
                                        this page</button>
                                </div>
                                <!--Files Modal-->
                                <!-- Modal -->
                                <div class="modal fade" id="showeditpagefiles" data-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Files (themes)</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    <input type="hidden" value="{{ $editview->id }}" id="page_id_file" />
                                                    <input type="hidden" id="pagination_page"
                                                        value="{{ $files->nextPageUrl() }}" />
                                                </button>
                                            </div>
                                            <div class="modal-body" id="file_modal">

                                                @include('admin.layouts.partials.showpagefiles')

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="attach_file_to_page"><i
                                                        class="bi bi-paperclip"></i>&nbsp;Attach</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Attached Files section-->
                                <div id="attached_files">
                                    @include('admin.layouts.partials.editpageatachedfiles')
                                </div>
                                <!--Attached FILES section-->
                                <!--End of Files selection section-->




                                {{-- <div class="form-group">
                                    <label for="">Page Content</label>
                                    <textarea name="description" id="editor1" cols="30" rows="10">
                                                        @if (is_countable($editview->fileforpages) && count($editview->fileforpages) > 0)
                                                            @foreach ($editview->fileforpages as $file)
                                                                @if ($file->extension == 'html')
                                                                {{ file_get_contents(substr($file->storage_path, 1)) }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ $editview->content }}
                                                        @endif
                                                        </textarea>
                                    <script>
                                        CKEDITOR.replace('editor1');
                                        CKEDITOR.config.allowedContent = true;
                                    </script>
                                </div> --}}

                                <div class="form-group">
                                    <label for="">Page Content</label>
                                    <textarea name="description" id="editor" cols="30" rows="10">

                                                        @if (is_countable($editview->fileforpages) && count($editview->fileforpages) > 0)
                                                            @foreach ($editview->fileforpages as $file)
                                                                @if ($file->extension == 'html')
                                                                {{ file_get_contents(substr($file->storage_path, 1)) }}
                                                                @endif
                                                            @endforeach
                                            @else
                                                            {{ $editview->content }}
                                                        @endif



                                                        </textarea>
                                    <script>
                                        tinymce.init({
                                            selector: 'textarea#editor',
                                            height: 500,
                                            menubar: false,
                                            element_format: 'html',
                                            apply_source_formatting: false, //added option
                                            verify_html: false, //added option
                                            plugins: [
                                                'advlist autolink lists link image charmap print preview anchor',
                                                'searchreplace visualblocks code fullscreen',
                                                'insertdatetime media table paste code help wordcount code media table paste imagetools'
                                            ],
                                            toolbar: 'undo redo | formatselect | ' +
                                                'bold italic backcolor | alignleft aligncenter ' +
                                                'alignright alignjustify | bullist numlist outdent indent | ' +
                                                'removeformat | searchreplace| visualblocks | code | link | image | print',
                                            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                                            paste_merge_formats: false,
                                            powerpaste_allow_local_images: true,
                                            valid_elements: '*[*],html[*],body[*],link[*]',
                                            extended_valid_elements: '*[*]',
                                            allow_unsafe_link_target: true,
                                            entity_encoding: 'raw',
                                            schema: 'html5'
                                        });
                                    </script>
                                </div>

                                <input type="hidden" name="page_id" id="page_id" value="{{ $editview->id }}" />


                                <!---Green button drop down Starts--->
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Page Options
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        <a href="" id="ajaxSubmit" onclick="UpdatePage({{ $editview->id }})"
                                            class="dropdown-item">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                <path fill-rule="evenodd"
                                                    d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                            </svg>&nbsp;
                                            Update page
                                        </a>
                                        <a href="{{ route('admin.pages') }}" class="dropdown-item">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-ppt-fill"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6.5 4.5a.5.5 0 0 0-1 0V12a.5.5 0 0 0 1 0V9.236a3 3 0 1 0 0-4.472V4.5zm0 2.5a2 2 0 1 0 4 0 2 2 0 0 0-4 0z" />
                                            </svg>&nbsp;
                                            See all
                                            pages</a>

                                        <a href="/page/{{ $editview->id }}/preview" class="dropdown-item" target="new">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-textarea-t"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M1.5 2.5A1.5 1.5 0 0 1 3 1h10a1.5 1.5 0 0 1 1.5 1.5v3.563a2 2 0 0 1 0 3.874V13.5A1.5 1.5 0 0 1 13 15H3a1.5 1.5 0 0 1-1.5-1.5V9.937a2 2 0 0 1 0-3.874V2.5zm1 3.563a2 2 0 0 1 0 3.874V13.5a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V9.937a2 2 0 0 1 0-3.874V2.5A.5.5 0 0 0 13 2H3a.5.5 0 0 0-.5.5v3.563zM2 7a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm12 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                <path
                                                    d="M11.434 4H4.566L4.5 5.994h.386c.21-1.252.612-1.446 2.173-1.495l.343-.011v6.343c0 .537-.116.665-1.049.748V12h3.294v-.421c-.938-.083-1.054-.21-1.054-.748V4.488l.348.01c1.56.05 1.963.244 2.173 1.496h.386L11.434 4z" />
                                            </svg>&nbsp;
                                            Page
                                            Preview</a>
                                        <a href="/admin/pages/create" class="dropdown-item">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                <path fill-rule="evenodd"
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>&nbsp;
                                            Add
                                            another page
                                        </a>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                    <!-- END Main page Info section-->
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
    <form action="" method="post" id="image_page_attachment">

    </form>

    <form action="" method="post" id="file_page_attachment">

    </form>
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999999; right: 0; bottom: 0;" id="bottom_toast">
    </div>

    <!--EDIT PAGE SECTION-->
    <script src="{{ asset('js/editpageajax.js') }}" defer></script>
    <!---END OF AJAX JS-->

@endsection
