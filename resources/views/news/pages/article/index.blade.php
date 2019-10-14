@extends('news.main', ['title' => 'Chi tiet'])
@section('content')
    <div class="section-category">
        @include('news.block.breadcrumb_article', ['item' => $itemArticle])
        <div class="content_container container_category">
            <div class="featured_title">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <!-- Main Content -->
                            <div class="single_post">
                                @include('news.pages.article.child-index.article', ['item' => $itemArticle])
                                @include('news.pages.article.child-index.related', ['item' => $itemArticle])
                            </div>
                        </div>
                        <!-- Sidebar -->
                        <div class="col-lg-3">
                            <div class="sidebar">
                                <!-- Latest Posts -->
                                @include('news.block.latest_posts', ['items' => $itemsLatest])
                                <!-- Extra -->
                                @include('news.block.advertisement', ['itemsAdvertisement' => []])
                                <!-- Most Viewed -->
                                @include('news.block.most_viewed', ['items' => $itemsMostViewed])
                                <!-- Tags -->
                                @include('news.block.tags', ['itemsTags' => []])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection