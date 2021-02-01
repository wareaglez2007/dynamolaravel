<div class="container" style="min-height: 650px;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        @if (count($item->childItems))
                            <!--Level 1-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{$item->slug->uri}}"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"> {{ $item->title }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @foreach ($item->childItems as $childItems)
                                        @include('admin.layouts.partials.sub_items', ['sub_items' => $childItems])
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item active">
                                <a class="nav-link" href="{{$item->slug->uri}}">{{ $item->title }}</a>
                            </li>
                        @endif

                    @endforeach
                @endif
            </ul>
        </div>
    </nav>
</div>
