@extends('news/login')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;   
    @endphp
    <div style="height: 100px">
    </div>
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Đăng ký</h4>
            @include('news.templates.error')
            {{ Form::open([
                'method' => 'post',
                'url' => route("$controllerName/postRegister"),
                'id' => 'auth-form' 
            ]) }}
            <form method="POST">
             
                <div class="form-group">
                    {!! Form::label('username', 'User name: ') !!}
                    {!! Form::text('username', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('fullname', 'Full name: ') !!}
                    {!! Form::text('fullname', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email: ') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Mật khẩu: ') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Nhập lại mật khẩu: ') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('level', 'Level: ') !!}
                    {!! Form::select('level', ['default' => 'Select level', 'admin' => config('zvn.template.level.admin.name'), 'member' => config('zvn.template.level.member.name')], null, ['class' => 'form-control', 'required' => true]) !!}
                </div>

                <div class="form-group no-margin">
                    <button type="submit" class="btn btn-primary btn-block">
                        Đăng ký
                    </button>
                </div>
                <div class="margin-top20 text-center">
                    Đã có tài khoản? <a href="index.html">Đăng nhập</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
