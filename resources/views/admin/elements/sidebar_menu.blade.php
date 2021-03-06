@php
    $src = asset('admin_template/img/img.jpg');
    if(session('userInfo') && session('userInfo')['avatar'] !== null) $src = asset('images/user' . '/' . session('userInfo')['avatar']);
@endphp
<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ $src }}" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>{!! __('Welcome, :name', ['name' => '<h2>' . session('userInfo')['fullname']]) . '</h2>' !!}</span>
    </div>
</div>
<!-- /menu profile quick info -->
<br/>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ __('General') }}</h3>
        <ul class="nav side-menu">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a></li>
            <li><a href="{{route('user')}}"><i class="fa fa-user"></i> {{ __('User') }}</a></li>
            <li><a href="{{route('category')}}"><i class="fa fa fa-building-o"></i> {{ __('Category') }}</a></li>
            <li><a href="{{route('article')}}"><i class="fa fa-newspaper-o"></i> {{ __('Article') }}</a></li>
        <li><a href="{{route('slider')}}"><i class="fa fa-sliders"></i> {{ __('Sliders') }}</a></li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->