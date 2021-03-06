<div class="col-md-12">
    <div class="row">
        <div class="col-md-4" style="margin-bottom: 10px; ">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.pages') }}" class="text-muted" title="Published Pages">
                        <span class="bi bi-folder-plus">&nbsp; Published</span>
                    </a>
                    <a href="{{ route('admin.pages') }}" class="text-muted" title="Published Pages">
                        <span class="badge bg-success rounded-pill"
                            style="color:#ffffff; ">{{ $publishcount }}</span>
                    </a>

                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.pages.draft') }}" class="text-muted" title="Darft Pages">
                        <span class="bi bi-folder-symlink">&nbsp;Drafts</span>
                    </a>
                    <a href="{{ route('admin.pages.draft') }}" class="text-muted" title="Darft Pages">
                        <span class="badge bg-primary rounded-pill"
                            style="color:#ffffff;">{{ $draftcount }}</span>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.pages.trash') }}" class="text-muted" title="Trashed Pages">
                        <span class="bi bi-trash">&nbsp;Trashed</span>
                    </a>
                    <a href="{{ route('admin.pages.trash') }}" class="text-muted" title="Trashed Pages">
                        <span class="badge bg-danger rounded-pill"
                            style="color:#ffffff;">{{ $trashed }}</span>
                    </a>
                </li>
            </ul>
        </div>


        <div class="col-md-4" style="margin-bottom: 10px; ">
            <ul class="list-group">
                <li class="list-group-item">Posts</li>
                <li class="list-group-item">Comments <span class="bi-shift"></span></li>

            </ul>
        </div>
        <div class="col-md-4" style="margin-bottom: 10px; ">
            <ul class="list-group">
                <li class="list-group-item">Published</li>
                <li class="list-group-item">Item</li>
                <li class="list-group-item ">Disabled item</li>
            </ul>
        </div>
    </div>
</div>
