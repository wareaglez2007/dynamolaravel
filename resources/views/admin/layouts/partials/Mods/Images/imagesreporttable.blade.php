@if (is_countable($report) && count($report) > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <?php session()->has('direction') ? ($direction = session()->get('direction')) :
                ($direction = 'DESC');

                ?>

                <th scope="col"><a href=""
                        onclick="event.preventDefault();DoSortBy('upload_images_id', '{{ session()->get('direction') }}' , {{ $report->currentPage() }});"
                        class="text-muted" id="image_id_sorter"><i class="bi bi-arrow-down-up h5"></i> Image Id</a></th>
                <th scope="col"><a href=""
                        onclick="event.preventDefault();DoSortBy('pages_id', '{{ session()->get('direction') }}' , {{ $report->currentPage() }});"
                        class="text-muted" id="page_id_sorter"><i class="bi bi-arrow-down-up h5"></i>
                        Page ID</a></th>
                <input type="hidden" id="pagination_sorter" data-sortby="{{ session()->get('sortby') }}"
                    data-direction="{{ session()->get('direction') }}"
                    data-sorticon="{{ session()->get('sort_icon') }}" />
                <th scope="col" class="text-muted">Page</th>
                <th scope="col" class="text-muted">Image</th>
                <th scope="col" class="text-muted">Preview</th>
                <th scope="col" class="text-muted">Detach</th>
            </tr>
        </thead>
        <script>
            function DoSortBy(orderby, direction, page) {

                if (direction == 'DESC') {
                    d = "ASC";
                    direction = "ASC";
                } else {
                    direction = "DESC";
                    d = "DESC";
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]')
                            .attr(
                                'content')
                    }

                }); //End of ajax setup
                $.ajax({
                    url: '/admin/Images/uploadimagereport',
                    method: "get",
                    //cache: false,
                    data: {
                        page: page,
                        sortby: orderby,
                        direction: direction,
                    },
                    success: function(data) {
                        var url = '/admin/Images/uploadimagereport?page=' + page;
                        //getView(url);
                        $('#image_report_section').html(data.view);
                        if (orderby == 'upload_images_id') {

                            $('#image_id_sorter').attr("onClick", "event.preventDefault();DoSortBy('" +
                                orderby + "','" + d + "','" + page + "');");

                        }
                        if (orderby == 'pages_id') {

                            $('#page_id_sorter').attr("onClick", "event.preventDefault();DoSortBy('" +
                                orderby + "','" + d + "','" + page + "');");

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
                            onclick="event.preventDefault();DetachImagesFromPage({{ $image_report->attachedPages->id }},{{ $image_report->getImages->id }}, {{ $report->currentPage() }}, {{ $report->count() }}, '{{ session()->get('sortby') }}', '{{ session()->get('direction') }}' );"><i
                                class="bi bi-x-square-fill text-danger"></i></a></td>
                </tr>
            @endforeach

        </tbody>

    </table>
    <span id="images_report_mod_pagination">
        {{ $report->withpath('/admin/Images/uploadimagereport') }}
    </span>
    <script>
        //This function will make sure pagination is handlled with Ajax in the background
        $(function() {
            $('#images_report_mod_pagination .pagination a').on('click', function(e) {
                e.preventDefault();
                //URL for the pagiantion
                var url = $(this).attr('href');
                var sortby = $("#pagination_sorter").data("sortby");
                var direction = $("#pagination_sorter").data("direction");

                getView(url + "&sortby=" + sortby + "&direction=" + direction);
            });


        });



        function DetachImagesFromPage(page_id, image_id, current_page, count, orderby, direction) {
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
                    sortby: orderby,
                    direction: direction,
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
                    getView(url + "&sortby=" + orderby + "&direction=" + direction);


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
            var sortby = $("#pagination_sorter").data("sortby");
            var direction = $("#pagination_sorter").data("direction");
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
