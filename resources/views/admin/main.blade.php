<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                @include('admin.elements.sidebar_title')
                @include('admin.elements.sidebar_menu')
            </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
            @include('admin.elements.top_nav')
        </div>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
            @yield('content')
        </div>
        <!-- /page content -->
        @include('admin.elements.footer')
    </div>
</div>
    @include('admin.elements.script')
    @include('admin.templates.zvn_notify');
</body>
</html>