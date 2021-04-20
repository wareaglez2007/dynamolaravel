@if (is_countable($report) && count($report) > 0)
    <table class="table table-hover">
        <thead>
            <tr>

                <th scope="col"><a href=""
                        onclick="event.preventDefault();DoSortBy('upload_images_id', 'DESC', {{ $report->currentPage() }});"
                        class="text-muted" id="image_id_sorter" data-sortby="upload_images_id" data-direction="DESC"><i
                            class="bi bi-sort-numeric-down text-secondary h4"></i> Image Id</a></th>
                <th scope="col"><a href=""
                        onclick="event.preventDefault();DoSortBy('pages_id', 'DESC', {{ $report->currentPage() }});"
                        class="text-muted" id="page_id_sorter" data-sortby="pages_id" data-direction="DESC"><i class="bi bi-sort-numeric-down text-secondary h4"></i>
                        Page ID</a></th>
                <th scope="col">Page Name</th>
                <th scope="col">Image Name</th>
                <th scope="col">Image Preview</th>
                <th scope="col">Detach</th>
            </tr>
        </thead>
        <script>
            function DoSortBy(orderby, direction, page) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]')
                            .attr(
                                'content')
                    }

                }); //End of ajax setup
                $.ajax({
                    url: '/admin/Images/uploadimagereport/pagination',
                    method: "get",
                    //cache: false,
                    data: {
                        page: page,
                        sortby: orderby,
                        direction: direction,
                    },
                    success: function(data) {
                        var d = "";
                        var icon = "";
                        if (direction == 'DESC') {
                            d = "ASC";
                            icon = "up-alt";
                        } else {
                            d = "DESC";
                            icon = "down";
                        }

                        var url = '/admin/Images/uploadimagereport/pagination?page=' + page;
                        //getView(url);
                        $('#image_report_section').html(data.view);
                        if (orderby == 'upload_images_id') {
                            $('#image_id_sorter').attr("onClick", "event.preventDefault();DoSortBy('" +
                                orderby + "','" + d + "','" + page + "');");
                                $('#image_id_sorter').attr("data-direction", d);
                            $('#image_id_sorter i').attr("class", "bi bi-sort-numeric-" + icon +
                                " text-secondary h4");
                        }
                        if (orderby == 'pages_id') {
                            $('#page_id_sorter').attr("onClick", "event.preventDefault();DoSortBy('" +
                                orderby + "','" + d + "','" + page + "');");
                            $('#page_id_sorter i').attr("class", "bi bi-sort-numeric-" + icon +
                                " text-secondary h4");
                                $('#page_id_sorter').attr("data-direction", d);
                        }
                    }, //end of success
                    error: function(error) {

                        $("#ajaxactioncallimages").attr('class', "alert alert-danger");
                        $.each(error.responseJSON.errors, function(index, val) {
                            $("#ajaxactioncallimages #e_message").html(
                                "<img src='/storage/ajax-loader-red.gif'/>" + val);
                            //   $('#ajaxactioncallimages').fadeOut(2500);
                            // console.log(index, val);
                        });

                        // console.log(error);


                    } //end of error
                }); //end of ajax
            }

        </script>
        <tbody>
            @foreach ($report as $image_report)
                <tr>
                    <th scope="row">
                        <a href="{{ route('admin.pages.edit', $image_report->attachedPages->id) }}"
                            class="text-muted">{{ $image_report->getImages->id }}</a>

                    </th>
                    <td><a href="{{ route('admin.pages.edit', $image_report->attachedPages->id) }}"
                            class="text-muted">{{ $image_report->attachedPages->id }}</a></td>
                    <td><a href="{{ route('admin.pages.edit', $image_report->attachedPages->id) }}"
                            class="text-muted">{{ $image_report->attachedPages->title }}</a></td>
                    <td><a href="{{ route('admin.pages.edit', $image_report->attachedPages->id) }}"
                            class="text-muted">{{ $image_report->getImages->image_original_name }}</a></td>
                    <td class="col-md-1" style="width:100px;"><a
                            href="{{ route('admin.pages.edit', $image_report->attachedPages->id) }}"
                            class="text-muted"><img src="{{ asset('storage/' . $image_report->getImages->file) }}"
                                class="img-thumbnail " class="upload-img-thumbnail"
                                alt="/images/thumbs/{{ $image_report->getImages->file }}" /></a></td>
                    <td><a href=""
                            onclick="event.preventDefault();DetachImagesFromPage({{ $image_report->attachedPages->id }},{{ $image_report->getImages->id }}, {{ $report->currentPage() }}, {{ $report->count() }} );"><i
                                class="bi bi-x-square-fill text-danger"></i></a></td>
                </tr>
            @endforeach

        </tbody>

    </table>
    <span id="images_report_mod_pagination">
        {{ $report->withpath('/admin/Images/uploadimagereport/pagination') }}
    </span>
    <script>
        //This function will make sure pagination is handlled with Ajax in the background
        $(function() {
            $('#images_report_mod_pagination .pagination a').on('click', function(e) {
                e.preventDefault();
                //URL for the pagiantion
                var url = $(this).attr('href');
                var sortby = $("#image_id_sorter").data("sortby");
                var direction = $("#image_id_sorter").data("direction");
                getView(url+"&sortby="+sortby+"&direction="+direction);
            });


        });



        function DetachImagesFromPage(page_id, image_id, current_page, count) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]')
                        .attr(
                            'content')
                }

            }); //End of ajax setup
            $.ajax({
                url: '/admin/Images/uploadimagereport/detachimage',
                method: "post",
                //cache: false,
                data: {
                    image_id: image_id,
                    page_id: page_id,
                },
                success: function(data) {
                    var delay = 2300;
                    color = "green";
                    //
                    var toast =

                        '<div id="detach_toast_id_' + image_id +
                        '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                        delay + '" >' +
                        '<div class="toast-header" style="background-color: ' +
                        color +
                        ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                        '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                        '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                        '<div class="toast-body" id="toast_id_body' +
                        image_id + '">' + data.response.success +
                        '</div> </div> </div>';
                    $("#bottom_toast").append(toast);
                    $('#detach_toast_id_' + image_id).toast("show");
                    $('#attached_image_modal_' + image_id).modal('hide');

                    setTimeout(function() {
                        $('#detach_toast_id_' + image_id)
                            .remove();

                    }, delay + 600);
                    if (count < 2 && current_page != 1) {
                        current_page = current_page - 1;
                    }
                    var url = '/admin/Images/uploadimagereport/pagination?page=' + current_page;
                    getView(url);


                }, //end of success
                error: function(error) {

                    $("#ajaxactioncallimages").attr('class', "alert alert-danger");
                    $.each(error.responseJSON.errors, function(index, val) {
                        $("#ajaxactioncallimages #e_message").html(
                            "<img src='/storage/ajax-loader-red.gif'/>" + val);
                        //   $('#ajaxactioncallimages').fadeOut(2500);
                        // console.log(index, val);
                    });

                    // console.log(error);


                } //end of error
            }); //end of ajax
        } //end of DetachImagesFromPage()


        function getView(url) {
            var sortby = $("#image_id_sorter").data("sortby");
            var direction = $("#page_id_sorter").data("direction");
            console.log(sortby);
            $.ajax({
                url: url,
                sortby: sortby,
                direction: direction,
                method: 'get'
            }).done(function(data) {
                $('#image_report_section').html(data.view);
            }).fail(function() {});
        }


    </script>
@else
    <p>Currently, there are no images that have been assigned to any page. </p>
@endif
