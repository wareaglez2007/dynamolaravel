<div class="tab-pane" id="draft" role="tabpanel" aria-labelledby="draft-tab">
    <!--This is the main pages view which will have a table that will show Dreft pagaes.-->
    <table class="table table-hover" id="drafts">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>


            @foreach ($draftpages as $k => $page)

                <tr id="pid{{ $page->id }}">
                    <!---Position field-->
                    <th scope="row" id="page_position_clone{{ $page->id }}">
                        <form action="admin/pages/update/updateposition" method="post">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a href="" class="text-muted btn-group btn-group-sm" id="position_updated{{ $page->id }}"
                                onclick="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} )"><i
                                    class="bi bi-arrow-down-up"></i></a>
                            <select class="form-control btn-group btn-group-sm" style="width: 80px;" name="position"
                                id="position{{ $page->id }}">
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
                                <a class="dropdown-item" href="{{ route('admin.pages.edit', $page->id) }}">Edit</a>
                                <!--Publish action -->
                                <a href="" onclick="event.preventDefault();PublishPage({{ $page->id }})"
                                    class="dropdown-item" id="publish_function{{ $page->id }}">Publish</a>
                                <!--Delete action--->
                                <a href=""
                                    onclick="event.preventDefault();DeletePage({{ $page->id }},{{ $page->parent_page_id }})"
                                    class="dropdown-item">Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>


            @endforeach



        </tbody>
    </table>
<div id="draft_pagination">
    {{$draftpages->withpath('/admin/pages/getdraftpages')}}
</div>


</div>
