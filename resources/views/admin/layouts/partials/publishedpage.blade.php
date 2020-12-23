<div class="tab-pane active" id="published" role="tabpanel">
    <!--This is the main pages view which will have a table that will show available pages.-->
    <table class="table table-hover" id="publishedpages">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">
                    <!---Bulk Actions -->
                    <div class="dropdown show btn btn-outline-success">
                        <a class="btn btn-sm dropdown-toggle " href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b>Bulk Actions</b>&nbsp;<i class="bi bi-toggles"></i>

                        </a>
                        <!--Edit action-->
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <!--Published page actions-->

                            <!--Delete action-->
                            <a href="" class="dropdown-item">Delete All</a>
                            <!--Unbublish action-->
                            <a href="" class="dropdown-item">Unpublish All</a>
                        </div>
                    </div>

                </th>
            </tr>

        </thead>
        <tbody>


            @foreach ($pageslist as $k => $page)
                <tr id="activeid{{ $page->id }}">
                    <!---Position field-->
                    <th scope="row" id="page_position_clone{{ $page->id }}">
                        <form action="admin/pages/update/updateposition" method="post">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a href="" class="text-muted btn-group btn-group-sm" id="position_updated{{ $page->id }}"
                                onclick="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} )"><i
                                    class="bi bi-arrow-down-up"></i>
                            </a>
                            <select class="form-control btn-group btn-group-sm" style="width: 80px;" name="position"
                                id="position{{ $page->id }}"
                                onchange="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} )">
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
                                    onclick="event.preventDefault();DeleteActivePage({{ $page->id }},{{ $page->parent_id }})"
                                    class="dropdown-item">Delete</a>
                                <!--Unbublish action-->
                                <a href="" onclick="event.preventDefault();UnPublishPage({{ $page->id }})"
                                    class="dropdown-item" id="unpublish_function{{ $page->id }}">Unpublish</a>
                            </div>
                        </div>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>


    {{ $pageslist->withPath('/admin/pages/getpublishedtpages') }}
</div>

<!---SCRIPT FOR UPDATE POSITION-->
<script>
    //END OF WINDOW ON LOAD
    function DoUpdatePosition(old_position, id) {
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
                setTimeout(function() { // wait for 7 mili secs(2)

                    location.reload(); // then reload the page.(3)
                }, 200);
            },
            error: function(errors) {

            }
        });
    }

</script>
