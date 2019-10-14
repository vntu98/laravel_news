@php
    use App\Helpers\Template;
    use App\Helpers\URL;
@endphp
<div class="most_viewed">
    <div class="sidebar_title">Xem nhiều nhẩt</div>
    <div class="most_viewed_items">
        <!-- Most Viewed Item -->
        @foreach($items as $key => $item)
            @php
                $index = ($key + 1) . '.';
                $name = $item['name'];
                $views = $item['views'];
                $categoryName = App\Models\ArticleModel::find($item['id'])->category['name'];
                $categoryId = App\Models\ArticleModel::find($item['id'])->category['id'];
                $linkCategory = URL::linkCategory($categoryId, $categoryName);
                $linkArticle = URL::linkArticle($item['id'], $name);
                $created = Template::showDateTimeFrontend($item['created']);
            @endphp
            <div class="most_viewed_item d-flex flex-row align-items-start justify-content-start">
                <div>
                    <div class="most_viewed_num">{!!$index!!}</div>
                </div>
                <div class="most_viewed_content">
                    <div class="post_category_small cat_video"><a href="{!!$linkCategory!!}">{!!$categoryName!!}</a>
                    </div>
                    <div class="most_viewed_title"><a href="{!!$linkArticle!!}">{!!$name!!}</a>
                    </div>
                    <div class="most_viewed_date"><a href="#">{!!$views!!} lượt xem</a></div>
                </div>
            </div>
        @endforeach
    </div>
</div>