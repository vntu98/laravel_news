<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('login/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login/css/my-login.css') }}">
	<link rel="stylesheet" href="{{asset('admin_template/css/toastr.min.css')}}">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
                    @yield('content')
                </div>
			</div>
		</div>
	</section>
	<script src="{{asset('admin_template/js/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('admin_template/asset/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('login/js/my-login.js') }}"></script>
	<script src="{{ asset('admin_template/js/toastr.min.js') }}"></script>
	@include('news.templates.zvn_notify')
</body>
</html>