

<b class="screen-overlay"></b>

<!-- offcanvas panel -->
<aside class="offcanvas" id="my_offcanvas1">
    <header class="p-4 bg-light border-bottom">
        <button class="btn btn-outline-danger btn-close"> &times Close </button>
        <h6 class="mb-0">First offcanvas </h6>
    </header>
    @if ($nav_style == 1)
        @include('admin.modules.Navigations.NavStyles.regular-menus.navigation')
    @else
        @include('admin.modules.Navigations.NavStyles.sideload-menus.navigation')
    @endif

</aside>

