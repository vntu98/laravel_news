@extends('news.main')
@section('content')
    @include('news.block.slider')
    <div class="content_container">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="main_content">
                        <!-- Featured -->
                        <div class="featured">
                            <div class="featured_title">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="section_title_container d-flex flex-row align-items-start justify-content-start">
                                                <div>
                                                    <div class="section_title">Nổi bật</div>
                                                </div>
                                                <div class="section_bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Featured Title -->
                            @include('news.block.featured', ['itemFeature' => []])
                        </div>
                        <!-- Category -->
                        @include('news.pages.home.child-index.category')
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar">
                        <!-- Latest Posts -->
                        @include('news.block.latest_posts', ['itemsLatest' => []])
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
@endsection