<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Throwable;

class AuthAdminController extends Controller
{
    public function __construct()
    {
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

        View::share('title', $title);
    }

    //vao trang chu
    public function dashboard()
    {
        return view('layout.master');
    }

    public function login()
    {
        return view('auth-admin.login');
    }

    public function processLogin(LoginRequest $request)
    {
        try {
            $user = User::query()
                ->where('email', $request->email)->firstOrFail();

            if (Hash::check($request->password, $user->password)){
                session()->put('id', $user->id);
                session()->put('name', $user->name);
                session()->put('role', $user->role);

                if ($user->status === 0){
                    return redirect()->route('admin.login')->with('message', 'Tài khoản của bạn đã bị khóa, liên hệ với quản trị viên để được giúp đỡ!');
                }

                //Ghi nho tai khoan
//                if (!empty($request->remember)){
//                    cookie()
//                }
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('admin.login')->with('message', 'Email hoặc mật khẩu không chính xác!');
            }

        }catch (Throwable $e){
            return redirect()->route('admin.login')->with('message', 'Email hoặc mật khẩu không chính xác!');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}
