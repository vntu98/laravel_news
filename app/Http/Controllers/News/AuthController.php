<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthLoginRequest as MainRequest;
use App\Models\UserModel;

class AuthController extends Controller
{
    private $pathViewController = 'news.pages.auth.';
    private $controllerName = 'auth';
    private $params = [];
    private $model;

    public function __construct(){
        view()->share('controllerName', $this->controllerName);
    }

    public function login(Request $request){
        return view($this->pathViewController . 'login');
    }

    public function postLogin(MainRequest $request){
        if($request->method() == 'POST'){
            $params = $request->all();
            $userModel = new UserModel();
            $userInfo = $userModel->getItem($params, ['task' => 'auth-login']);
            if(!$userInfo) return redirect()->route($this->controllerName . '/login')->with('zvn_notify', 'Tài khoản hoặc mật khẩu không chính xác!');
            $request->session()->put('userInfo', $userInfo);
            return redirect()->route('home');
        }
    }

    public function register(Request $request){
        return view($this->pathViewController . 'register');
    }

    public function postRegister(MainRequest $request){
        if($request->method() == 'POST'){
            $params = $request->all();
            $params['status'] = 'active';
            $userModel = new UserModel();
            $userInfo = $userModel->getItem($params, ['task' => 'auth-login']);
            $userModel->saveItem($params, ['task' => 'add-item']);
            return redirect()->route($this->controllerName . '/login')->with('zvn_notify', 'Đăng ký tài khoản thành công!');
        }
    }

    public function logout(Request $request){
        if($request->session()->has('userInfo')) $request->session()->pull('userInfo');
        return redirect()->route('home');
    }
}
