@php
    use App\Helpers\URL;
    $categoryName = App\Models\ArticleModel::find($item['id'])->category['name'];
    $categoryId = App\Models\ArticleModel::find($item['id'])->category['id'];
    $linkCategory = URL::linkCategory($categoryId, $categoryName);
@endphp
<div class="home">
    <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="{!! asset('news_template/images/footer.jpg') !!}" data-speed="0.8"></div>
    <div class="home_content_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content">
                        <div class="home_title">{{$item['name']}}</div>
                        <div class="breadcrumbs">
                            <ul class="d-flex flex-row align-items-start justify-content-start">
                                <li><a href="{{route('home')}}">Trang chủ</a></li>
                                <li><a href="{{$linkCategory}}">{{$categoryName}}</a></li>
                                <li>{{$item['name']}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>