<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <ul>
        @if (count($items) > 0)
            @foreach ($items as $item)
                <li>{{ $item->title }}</li>
                <ul>
                    @if (count($item->childItems))
                        @foreach ($item->childItems as $childItems)
                            @include('admin.layouts.partials.sub_items', ['sub_items' => $childItems])
                        @endforeach
                    @endif
                </ul>
            @endforeach
        @endif
    </ul>
</div>





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
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $item->title }}
                                @foreach ($item->childItems as $childItems)
                                    @include('admin.layouts.partials.sub_items', ['sub_items' => $childItems])
                                @endforeach
                            </a>

                        </li>
                    @else
                        <li class="nav-item active">

                            <a class="nav-link" href="#">{{ $item->title }}</a>

                        </li>
                    @endif

                @endforeach
            @endif
        </ul>
    </div>
</nav>
