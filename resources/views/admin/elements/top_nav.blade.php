@php
    $src = asset('admin_template/img/img.jpg');
    if(session('userInfo') && session('userInfo')['avatar'] !== null) $src = asset('images/user' . '/' . session('userInfo')['avatar']);
@endphp
<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ $src }}" alt="">{{ session('userInfo')['fullname'] }}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{ route('auth/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>