@php
    use App\Models\CategoryModel as CategoryModel;
    $categoryModel = new CategoryModel;
    $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items']);
    $xhtmlMenu = '';
    $xhtmlMenuMobile = '';
    if(count($itemsCategory) > 0){
        $xhtmlMenu = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
        $xhtmlMenuMobile = '<nav class="menu_nav"><ul class="menu_mm">';
        foreach($itemsCategory as $key => $val){
            $xhtmlMenu .= sprintf('<li><a href="#">%s</a></li>', $val['name']);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="#">%s</a></li>', $val['name']);
        }
        $xhtmlMenu .= '</ul></nav>';
        $xhtmlMenuMobile .= '</ul></nav>';
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
                            <a href="#">
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