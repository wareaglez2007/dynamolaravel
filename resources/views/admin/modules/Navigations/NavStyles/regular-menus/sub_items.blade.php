<!--Beginning of Regular Sub Menu Style-->
@if (count($sub_items->items) > 0)
    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle xx" href="{{$sub_items->slug->uri}}">{{ $sub_items->title }}</a>
    @else
    <li><a class="dropdown-item" href="{{$sub_items->slug->uri}}">{{ $sub_items->title }}</a></li>
@endif


@if ($sub_items->items)
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        @if (count($sub_items->items) > 0)
            @foreach ($sub_items->items as $childItems)
                @include('admin.modules.Navigations.NavStyles.regular-menus.sub_items', ['sub_items' => $childItems])
            @endforeach
        @endif
    </ul>
@endif


<style>
    .navbar-nav li:hover>ul.dropdown-menu {
        display: block;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
    }

    /* rotate caret on hover */
    .dropdown-menu>li>a:hover:after {
        text-decoration: underline;
        transform: rotate(-90deg);
    }

</style>
<!---End of Regular Sub Menu Style-->
