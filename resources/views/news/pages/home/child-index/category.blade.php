@foreach($itemsCategory as $item)
    @if(count($item['articles']) > 0)
        @if($item['display'] == 'list')
            @include('news.pages.home.child-index.category_list')
        @else
            @include('news.pages.home.child-index.category_grid')
        @endif
    @endif
@endforeach