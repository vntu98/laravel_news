@extends('news.main', ['title' => 'Chi tiet'])
@section('content')
    <div class="section-category">
        <div class="content_container container_category">
            <div class="featured_title">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <!-- Main Content -->
                            <div class="main_content">
                                <h3 style="color: red;">Bạn không có quyền truy cập vào chức năng này!!</h3>
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