@if(count($item['articles']) > 0)
    @if($item['display'] == 'list')
        @include('news.pages.category.child-index.category_list')
    @else
        @include('news.pages.category.child-index.category_grid')
    @endif
@endif