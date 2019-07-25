<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0">
                <span class="label label-info label-pagination">{{ $items->perPage() }} items per page</span>
                &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-success label-success">{{ $items->total() }} items</span>
                &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-success label-danger">{{ $items->lastPage() }} pages</span>
            </p>
        </div>
        <div class="col-md-6">
            {{ $items->appends(request()->input())->links('pagination.pagination_backend') }}
        </div>
    </div>
</div>