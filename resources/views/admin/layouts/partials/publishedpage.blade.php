<div class="tab-pane active" id="published" role="tabpanel">
    <!--This is the main pages view which will have a table that will show available pages.-->
    <table class="table table-hover" id="publishedpages">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">
                    <!-- Bulk Actions -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success">Actions</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();BulkUnpublish();">Bulk
                                unpublish</a>
                            <a class="dropdown-item" href="#">Bulk delete</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.pages.create') }}">Create new page</a>
                        </div>
                    </div>
                </th>
            </tr>

        </thead>
        <tbody>

            @if ($publishcount != 0)
                @foreach ($pageslist as $k => $page)
                    <tr id="activeid{{ $page->id }}" class="eachrow">
                        <!---Position field-->
                        <th scope="row" id="page_position_clone{{ $page->id }}">
                            <form action="admin/pages/update/updateposition" method="post">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a href="" class="text-muted btn-group btn-group-sm"
                                    id="position_updated{{ $page->id }}"
                                    onclick="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }}, {{ $pageslist->currentPage() }} )"><i
                                        class="bi bi-arrow-down-up"></i>
                                </a>
                                <select class="form-control btn-group btn-group-sm" style="width: auto;" name="position"
                                    id="position{{ $page->id }}"
                                    onchange="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} , {{ $pageslist->currentPage() }}, '/admin/pages')">
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
                        <td><a href="{{ route('admin.pages.edit', $page->id) }}"
                                class="text-muted">{{ $page->title }}</a>
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
                                        onclick="event.preventDefault();DeleteAnyPage({{ $page->id }},{{ $page->parent_id != null ? $page->parent_id : 0 }}, {{ $pageslist->currentPage() }},{{ $pageslist->firstItem() }},{{ $pageslist->lastItem() }},'')"
                                        class="dropdown-item">Delete</a>
                                    <!--Unbublish action-->
                                    <a href=""
                                        onclick="event.preventDefault();UnPublishPage({{ $page->id }}, {{ $pageslist->currentPage() }},{{ $pageslist->firstItem() }},{{ $pageslist->lastItem() }})"
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
    <hr />
    <div id="published_pagination">
        {{ $pageslist->withPath('/admin/pages') }}
    </div>
</div>


<script>
    $(function() {
        $('#published_pagination .pagination a').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            getPublished(url);
            //window.history.pushState("", "", url);
        });

        function getPublished(url) {
            $.ajax({
                url: url
            }).done(function(data) {
                $('#some_ajax').html(data);
            }).fail(function() {});
        }
    });



</script>
