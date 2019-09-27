<div class="posts">
    <div class="col-lg-12">
        <div class="row">
            @foreach ($item['articles'] as $article)
                <div class="col-lg-6">
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                        @include('news.partials.article.image', ['item' => $article])
                        @include('news.partials.article.content', ['item' => $article, 'lengthContent' => 100, 'showCategory' => false])
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="home_button mx-auto text-center"><a href="#">Xem
                thêm</a></div>
        </div>
    </div>
</div>