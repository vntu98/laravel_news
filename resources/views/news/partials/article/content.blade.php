@php
    use App\Helpers\Template; 
    use App\Helpers\URL;
    $name = $item['name'];
    $thumb = asset('images/article') . '/' . $item['thumb'];
    $categoryName = App\Models\ArticleModel::find($item['id'])->category['name'];
    $categoryId = App\Models\ArticleModel::find($item['id'])->category['id'];
    if($showCategory){
        $linkCategory = URL::linkCategory($categoryId, $categoryName);
    }
    $linkArticle = URL::linkArticle($item['id'], $item['name']);
    $created = Template::showDateTimeFrontend($item['created']);
    $created_by = $item['created_by'];
    if($lengthContent == 'full'){
        $content = $item['content'];
    }else{
        $content = Template::showContent($item['content'], $lengthContent);
    }
@endphp
<div class="post_content">
    @if($showCategory)
        <div class="post_category cat_technology "> <a href="{{ $linkCategory }}">{{ $categoryName }}</a> </div>
    @endif
    <div class="post_title"><a href="{{ $linkArticle }}">{{ $name }}</a></div>
    <div class="post_info d-flex flex-row align-items-center justify-content-start">
        <div class="post_author d-flex flex-row align-items-center justify-content-start">
            <div class="post_author_name"><a href="#">{{ $created_by }}</a>
            </div>
        </div>
        <div class="post_date"><a href="#">{{ $created }}</a></div>
    </div>
    @if($lengthContent > 0)
        <div class="post_text">
            <p> {!! $content !!} </p>
        </div>
    @endif
    @if($lengthContent == 'full' && $lengthContent !== 0)
        <div class="post_text">
            <p> {!! $content !!} </p>
        </div>
    @endif
</div>