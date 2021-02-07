
<div class="just-padding">

    <div class="list-group list-group-root well">


        @if (count($items) > 0)
            @foreach ($items as $item)
                @if (count($item->childItems))
                    <!-- Have children-->
                    <a href="#item-{{ $item->id }}" class="list-group-item text-muted" data-toggle="collapse">
                        <i class="bi bi-plus-circle" style="font-size: 15px;"></i>&nbsp;{{ $item->title }}
                    </a>
                    <!--Second level-->
                    <div class="list-group collapse" id="item-{{ $item->id }}">

                        @foreach ($item->childItems as $childItems)
                            @include('admin.modules.Navigations.NavStyles.sideload-menus.sub_items', ['sub_items' => $childItems])
                        @endforeach
                    </div>


                @else
                    <!--Top Level with no Child-->
                    <a href="{{$item->slug->uri}}" class="list-group-item text-muted">
                        {{ $item->title }}
                    </a>
                @endif

            @endforeach
        @endif
    </div>

</div>
<script>
    $(function() {

        $('.list-group-item').on('click', function() {
          $('.bi', this)
            .toggleClass('bi-plus-circle')
            .toggleClass('bi-dash-circle');
        });

      });
</script>
