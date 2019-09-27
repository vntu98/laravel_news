<div class="sidebar_latest">
    <div class="sidebar_title">Bài viết gần đây</div>
    <div class="latest_posts">
        @php
            use App\Helpers\Template;
            use App\Helpers\URL;
        @endphp
        @foreach($items as $item)
            @php
                $name = $item['name'];
                $categoryName = App\Models\ArticleModel::find($item['id'])->category['name'];
                $categoryId = App\Models\ArticleModel::find($item['id'])->category['id'];
                $thumb = asset('images/article') . '/' . $item['thumb'];
                $linkCategory = URL::linkCategory($categoryId, $categoryName);
                $linkArticle = URL::linkArticle($item['id'], $name);
                $created = Template::showDateTimeFrontend($item['created']);
                $created_by = $item['created_by'];
                $content = Template::showContent($item['content'], 0);
            @endphp
            <!-- Latest Post -->
            <div class="latest_post d-flex flex-row align-items-start justify-content-start">
                <div>
                    <div class="latest_post_image"><img src="{{$thumb}}" alt="{{$name}}"> </div>
                </div>
                <div class="latest_post_content">
                    <div class="post_category_small cat_video"><a href="{{$linkCategory}}">{{$categoryName}}</a></div>
                    <div class="latest_post_title"><a
                            href="{{$linkArticle}}">{{$name}}</a></div>
                    <div class="latest_post_date">{{$created}}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>