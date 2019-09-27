<div class="row">
    <div class="col-lg-8">
        <!-- Post -->
        <div class="post_item post_v_large d-flex flex-column align-items-start justify-content-start">
            <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                @include('news.partials.article.image', ['item' => $items[0]])
                @include('news.partials.article.content', ['item' => $items[0], 'lengthContent' => 500, 'showCategory' => true])
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @php unset($items[0]) @endphp
        @foreach ($items as $item)
            <div>
                <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                    @include('news.partials.article.image', ['item' => $item])
                    @include('news.partials.article.content', ['item' => $item, 'lengthContent' => 0, 'showCategory' => true])
                </div>
            </div>
        @endforeach
    </div>
</div>