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
                    <script>
                        $(document).ready(function() {
                            $(".switch input[type=checkbox]").click(function() {

                                $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                'content')
                                        }
                                    }),


                                    $.ajax({
                                        type: "POST",
                                        url: "/admin/pages/edit/updatestatus",
                                        data: {
                                            page_id: $("#page_id").val(),
                                            status: $(this).prop("checked") ? 1 : 0
                                        },
                                        success: function(response) {
                                            console.log(response);
                                        }
                                    });
                            });
                        });

                    </script>

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
                                <!--Questions for components
                                            1. is this page a homepage? Y/N
                                            2. Carousel? Y/N
                                            3. if yes. Add section for carousel and adding images.
                                            4....
                                        -->
                                <!--Section 1 q1 -->
                                <div class="form-group">
                                    <label for="" class="form-label">Is this a homepage?</label>
                                    <input type="checkbox" name="is_homepage" id="is_homepage" class=""
                                        aria-describedby="helpId" @if ($editview->is_homepage == 1) value="1" checked
                                        @else
                                                value="null" @endif

                                                @if ($homepageCount != 0 && $editview->is_homepage != 1 )
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
                                <script>
                                    $(document).ready(function() {
                                        $("#is_homepage").on('change', function() {

                                            homepage = $(this).prop("checked") ? 1 : null;
                                            console.log(homepage);
                                            $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                                            .attr(
                                                                'content')
                                                    }
                                                }),


                                                $.ajax({
                                                    type: "POST",
                                                    url: "/admin/pages/edit/homepage",
                                                    data: {
                                                        page_id: $("#page_id").val(),
                                                        status: homepage
                                                    },
                                                    success: function(response) {

                                                        console.log(response.success);
                                                        $('#homepage_message').attr('class',
                                                            'text-success');
                                                        $('#homepage_message').text(response
                                                            .success);


                                                    },
                                                    error: function(response) {
                                                        console.log(response.responseJSON.errors);
                                                        $('#homepage_message').attr('class',
                                                            'text-danger');
                                                        $('#homepage_message').text(response.responseJSON.errors);

                                                    }
                                                });
                                        });
                                    });

                                </script>
                                <!-- END Components section---->




                                <!---Images Section-->
                                <p>Media: <i>(Select images for this page)</i></p>

                                <!---END IMAGES SECTION-->
                                <div class="form-group">
                                    <label for="">Page Content</label>
                                    <textarea name="description" id="editor" cols="30"
                                        rows="10">{{ $editview->content }}</textarea>
                                    <script>
                                        CKEDITOR.replace('editor');
                                        CKEDITOR.config.allowedContent = true;

                                    </script>
                                </div>

                                <input type="hidden" name="page_id" id="page_id" value="{{ $editview->id }}" />



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
    <script>
        //EventListener Click
        $(window).on("load", function() {
            $('#ajaxSubmit').on('click', function(e) {
                e.preventDefault();
                $('#ajax_messages').html('');
            }); //End of on Click


            //If the title of the page has already been taken then give error
            //Ajax call to see if title
            $('#title').on('blur', function() {
                var page_title = $('#title').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                }); //End of ajax setup
                $.ajax({
                    url: "/admin/pages/create/validatenewdata",
                    method: "post",
                    data: {
                        title: page_title,
                        flag: true,
                        id: $('#page_id').val()

                    },
                    success: function(response) {
                        $('#helpId').attr('class',
                            'text-success');
                        $('#helpId').text(response.success);
                    }, //end of success
                    error: function(error) {
                        $('#title').focus();
                        setTimeout(function() {
                            $('#title').focus()
                        }, 50);
                        $('#helpId').attr('class',
                            'text-danger');
                        $('#helpId').text(error.responseJSON
                            .errors
                            .title);


                    } //end of error
                }); //end of ajax

            });
        });

        function UpdatePage(id) {
            //Post requests
            var PageTitle = $('#title').val();
            var PageSubTitle = $('#subtitle').val();
            var PageParent = $('select#page_parent').val();
            var PageOwner = $('#owner').val();
            var PageDesription = CKEDITOR.instances.editor.getData();
            var slug = $('#slug').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            }); //End of AjaxSetup
            $.ajax({
                url: "/admin/pages/update",
                method: "post",
                data: {
                    id: id,
                    title: PageTitle,
                    subtitle: PageSubTitle,
                    parent_id: PageParent,
                    owner: PageOwner,
                    description: PageDesription,
                    slug: slug,

                }, //End of data
                success: function(response) {
                    $('#ajax_messages').text("");
                    $('#mtype').attr('class',
                        'btn btn-success');
                    $('#ajax_messages').append('<h4>' + response
                        .success +
                        '</h4>');
                    $('#modal').modal('show');

                    setTimeout(function() { // wait for 5 secs(2)


                        location.reload(); // then reload the page.(3)
                    }, 700);


                }, //end of respnse
                error: function(error) {
                    $('#ajax_messages').text("");
                    $('#mtype').attr('class',
                        'btn btn-danger');
                    $('#ajax_messages').append('<ol>');
                    for (var prop in error.responseJSON.errors) {
                        var item = error.responseJSON.errors[prop];
                        $('#ajax_messages ol').append('<li><h4>' + item +
                            '</h4></li>');

                    }
                    $('#modal').modal('show')

                }

            }); //End of Ajax Call


        }

    </script>


    <!---IMAGE AJAX UPLOAD SECTION-->
    <script src="{{ asset('js/ajax/uploadimage.js') }}" defer></script>
    <!---END OF AJAX FOR UPLOAD -->
@endsection
