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
                            @include('admin.modules.Navigations.NavStyles.sideload-menus.sub_items', ['sub_items' =>
                            $childItems])
                        @endforeach
                    </div>


                @else
                    <!--Top Level with no Child-->
                    <a href="{{ $item->slug->uri }}" class="list-group-item text-muted">
                        {{ $item->title }}
                    </a>
                @endif

            @endforeach
        @endif
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Admin</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Account Settings">
                <i class="bi bi-gear-wide-connected"></i>
            </a>
        </h6>
        <!-- Authentication Links -->
        @guest

            <a class="list-group-item text-muted" href="{{ route('login') }}">
                <i class="bi bi-person-badge"></i>&nbsp;{{ __('Login') }}
            </a>

            @if (Route::has('register'))

                <a class="list-group-item text-muted" href="{{ route('register') }}">
                    <i class="bi bi-person-plus-fill"></i>&nbsp;{{ __('Register') }}
                </a>

            @endif
        @else

            <a class="list-group-item text-muted" href="{{ route('admin.home') }}">
                <i class="bi bi-person-square"></i>&nbsp;{{ Auth::user()->name }}
            </a>
            <a class="list-group-item text-muted" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                <i class="bi bi-door-open-fill"></i>&nbsp;{{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>


        @endguest

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
