<?php

namespace App\Http\Controllers\Customer;

use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AuthCustomerController extends Controller
{
    public function __construct()
    {
//        $this->model = new Customer();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

        $genders = GenderEnum::getArrayGender();
        View::share('title', $title);
        View::share('genders', $genders);
    }

    public function register()
    {
        return view('auth-customer.register');
    }

    public function processRegister(RegisterRequest $request)
    {
        Customer::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'address'=>$request->address,
            'gender'=>$request->gender,
        ]);
        return redirect()->route('customers.login')
            ->with('success', 'Bạn đã đăng ký thành công!');
    }

    public function login()
    {
        return view('auth-customer.login');
    }

    public function processLogin(LoginRequest $request)
    {
        $customer = Customer::query()
            ->where('email', $request->email)
            ->first();
        if ($customer && Hash::check($request->password, $customer->password)) {
            if ($customer->status == 0) {
                return redirect()->route('customers.login')
                    ->with('message', 'Tài khoản của bạn đang bị khóa hãy liên hệ quản trị viên để được hỗ trợ!');
            }
            session()->put('customer_id', $customer->id);
            session()->put('customer_name', $customer->name);
            if ($request->url == URL::route('customers.login')
                ||$request->url == URL::route('customers.register'))
            {
                return redirect()->route('customers.index');
            }
            return redirect($request->url ?? URL::route('customers.index'));
        }else{
            return redirect()->route('customers.login')
                ->with('message', 'Email hoặc mật khẩu của bạn không chính xác!');
        }

    }

    public function logout()
    {
        session()->forget('customer_id');
        session()->forget('customer_name');
        session()->forget('customer_email');
        session()->forget('customer_address');
        session()->forget('customer_phone_number');
        return redirect()->route('customers.index');
    }

    public function editProfile()
    {
        $customer = Customer::query()->find(session('customer_id'));

        return view('customer.profile.profile', [
            'customer' => $customer,
        ]);
    }

    public function updateProfile(UpdateCustomerRequest $request)
    {
        $customer = Customer::query()->find(session('customer_id'));
        $customer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'gender' => $request->gender,
        ]);
        return redirect()->route('customers.index')
            ->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }
}
