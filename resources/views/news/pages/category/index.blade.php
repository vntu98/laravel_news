@extends('news.main', ['title' => $itemCategory['name']])
@section('content')
    <div class="section-category">
        @include('news.block.breadcrumb', ['item' => $itemCategory])
        <div class="content_container container_category">
            <div class="featured_title">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                        <!-- Main Content -->
                            @include('news.pages.category.child-index.category', ['item' => $itemCategory])
                        </div>
                        <!-- Sidebar -->
                        <div class="col-lg-3">
                            <div class="sidebar">
                                <!-- Latest Posts -->
                                @include('news.block.latest_posts', ['items' => $itemsLatest])
                                <!-- Extra -->
                                @include('news.block.advertisement', ['itemsAdvertisement' => []])
                                <!-- Most Viewed -->
                                @include('news.block.most_viewed', ['itemsMostViewed' => []])
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