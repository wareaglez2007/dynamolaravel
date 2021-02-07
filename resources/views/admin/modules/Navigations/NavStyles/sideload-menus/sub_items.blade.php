<!----SUB MENU-->
@if (count($sub_items->items) > 0)
    <!--If it has other children-->

    <a href="#item-{{ $item->id }}-{{ $sub_items->id }}" class="list-group-item text-muted" data-toggle="collapse">
        <i class="bi bi-plus-circle" style="font-size: 15px;"></i>&nbsp;{{ $sub_items->title }}
    </a>


@else

    <!--Just itself-->
    <a href="{{$sub_items->slug->uri}}" class="list-group-item text-muted">
        {{ $sub_items->title }}
    </a>

@endif

@if ($sub_items->items)

    <div class="list-group collapse" id="item-{{ $item->id }}-{{ $sub_items->id }}" >
        @if (count($sub_items->items) > 0)
            @foreach ($sub_items->items as $childItems)

                @include('admin.modules.Navigations.NavStyles.sideload-menus.sub_items', ['sub_items' => $childItems])

            @endforeach
        @endif
    </div>

@endif
