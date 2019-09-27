@extends('news/login')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;   
    @endphp
    <div class="card fat" style="margin-top: 30%;">
        <div class="card-body">
            <h4 class="card-title">Đăng nhập</h4>
            @include('news.templates.error')
            {{ Form::open([
                'method' => 'post',
                'url' => route("$controllerName/postLogin"),
                'id' => 'auth-form' 
            ]) }}
            <form method="POST">
             
                <div class="form-group">
                    {!! Form::label('email', 'Email: ') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Mật khẩu: ') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                </div>

                <div class="form-group no-margin">
                    <button type="submit" class="btn btn-primary btn-block">
                        Đăng nhập
                    </button>
                </div>
                <div class="margin-top20 text-center">
                    Bạn chưa có tài khoản? <a href="{{route('auth/register')}}">Tạo mới</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
