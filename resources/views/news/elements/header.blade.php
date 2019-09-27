@php
    use App\Models\CategoryModel as CategoryModel;
    use App\Helpers\URL;
    $categoryModel = new CategoryModel;
    $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items']);
    $xhtmlMenu = '';
    $xhtmlMenuMobile = '';
    if(count($itemsCategory) > 0){
        $xhtmlMenu = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
        $xhtmlMenuMobile = '<nav class="menu_nav"><ul class="menu_mm">';
        $categoryIdCurrent = Route::input('category_id');
        foreach($itemsCategory as $key => $val){
            $link = URL::linkCategory($val['id'], $val['name']);
            $classActive = ($categoryIdCurrent == $val['id']) ? 'class="active"' : '';
            $xhtmlMenu .= sprintf('<li %s><a href="%s">%s</a></li>', $classActive, $link, $val['name']);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="#">%s</a></li>', $val['name']);
        }
        if(session('userInfo'))
            $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/logout'), 'Đăng xuất');
        else
            $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/login'), 'Đăng nhập');
        $xhtmlMenu .=  $xhtmlMenuUser . '</ul></nav>';
        $xhtmlMenuMobile .= $xhtmlMenuUser . '</ul></nav>';
    }
@endphp
<header class="header">
    <!-- Header Content -->
    <div class="header_content_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justfy-content-start">
                        <div class="logo_container">
                            <a href="{{route('home')}}">
                                <div class="logo"><span>NEW</span>s</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Navigation & Search -->
    <div class="header_nav_container" id="header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_nav_content d-flex flex-row align-items-center justify-content-start">
                        <!-- Logo -->
                        <div class="logo_container">
                            <a href="#">
                                <div class="logo"><span>ZEND</span>VN</div>
                            </a>
                        </div>
                        {!! $xhtmlMenu !!}
                        <!-- Hamburger -->
                        <div class="hamburger ml-auto menu_mm"><i class="fa fa-bars  trans_200 menu_mm" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
        <div class="menu_close_container">
            <div class="menu_close">
                <div></div>
                <div></div>
            </div>
        </div>
        <nav class="menu_nav">
            <ul class="menu_mm">
                {!! $xhtmlMenuMobile !!}
            </ul>
        </nav>
    </div>
</header>