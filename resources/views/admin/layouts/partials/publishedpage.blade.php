<div class="tab-pane active" id="published" role="tabpanel">
    <!--This is the main pages view which will have a table that will show available pages.-->
    <table class="table table-hover" id="publishedpages">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Actions</th>
            </tr>

        </thead>
        <tbody>

            @if ($publishcount != 0)
            @foreach ($pageslist as $k => $page)
                <tr id="activeid{{ $page->id }}">
                    <!---Position field-->
                    <th scope="row" id="page_position_clone{{ $page->id }}">
                        <form action="admin/pages/update/updateposition" method="post">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a href="" class="text-muted btn-group btn-group-sm" id="position_updated{{ $page->id }}"
                                onclick="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }}, {{$pageslist->currentPage()}} )"><i
                                    class="bi bi-arrow-down-up"></i>
                            </a>
                            <select class="form-control btn-group btn-group-sm" style="width: auto;" name="position"
                                id="position{{ $page->id }}"
                                onchange="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} , {{$pageslist->currentPage()}})">
                                @for ($i = 1; $i <= $allcount; $i++)
                                    @if ($i == $page->position)

                                        <option value="{{ $page->position }}" {{ $selected = 'selected' }}>
                                            {{ $page->position }}
                                        </option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}
                                        </option>

                                    @endif
                                @endfor
                            </select>

                        </form>
                    </th>

                    <!--Id-->
                    <th scope="row"><a href="{{ route('admin.pages.edit', $page->id) }}"
                            class="text-muted">{{ $page->id }}</a></th>
                    <td><a href="{{ route('admin.pages.edit', $page->id) }}" class="text-muted">{{ $page->title }}</a>
                    </td>
                    <td style="text-align: center">
                        <div class="dropdown show">
                            <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-toggle-off"></i>

                            </a>
                            <!--Edit action-->
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <!--Published page actions-->
                                <!--Edit action -->
                                <a href="" onclick="event.preventDefault();EditActivePage({{ $page->id }})"
                                    class="dropdown-item">Edit</a>
                                <!--Delete action-->
                                <a href=""
                                    onclick="event.preventDefault();DeleteAnyPage({{ $page->id }},{{ $page->parent_id != NULL ? $page->parent_id : 0 }}, {{$pageslist->currentPage()}},{{$pageslist->firstItem()}},{{$pageslist->lastItem()}},'')"
                                    class="dropdown-item">Delete</a>
                                <!--Unbublish action-->
                                <a href="" onclick="event.preventDefault();UnPublishPage({{ $page->id}}, {{$pageslist->currentPage()}},{{$pageslist->firstItem()}},{{$pageslist->lastItem()}})"
                                    class="dropdown-item" id="unpublish_function{{ $page->id }}">Unpublish</a>
                            </div>
                        </div>
                    </td>
                </tr>

            @endforeach
            @else
            <tr id="notrashpages">
                <th class="text-muted">There is no item here yer.</th>
            </tr>
        @endif
        </tbody>
    </table>
<hr/>

    {{ $pageslist->withPath('/admin/pages') }}

</div>

<!---SCRIPT FOR UPDATE POSITION-->
<script>
    //END OF WINDOW ON LOAD
    function DoUpdatePosition(old_position, id, cpage) {
        var old_position = old_position;
        var new_position = $('select#position' + id).val();
        console.log(old_position + " " + new_position + " " + id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                        'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        });
        $.ajax({
            url: "/admin/pages/update/updateposition",
            type: "post",
            data: {
                old_p: old_position,
                new_p: new_position,
                id: id
            },
            success: function(response) {
               // setTimeout(function() { // wait for 7 mili secs(2)

                 //   location.reload(); // then reload the page.(3)
              //  }, 200);


                var url = '/admin/pages?page='+cpage;
                console.log(url);
                getPublished(url);

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





            },
            error: function(errors) {

            }
        });
    }

    $(function() {
            $('#published .pagination a').on('click', function(e) {
                e.preventDefault();

                //  $('#load a').css('color', '#dfecf6');
                //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

                var url = $(this).attr('href');
                getPublished(url);
              //  window.history.pushState("", "", url);
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

</script>
