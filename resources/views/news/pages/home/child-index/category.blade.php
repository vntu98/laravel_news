@foreach($itemsCategory as $item)
    @if($item['display'] == 'list')
        @include('news.pages.home.child-index.category_list')
    @else
        @include('news.pages.home.child-index.category_grid')
    @endif
@endforeach