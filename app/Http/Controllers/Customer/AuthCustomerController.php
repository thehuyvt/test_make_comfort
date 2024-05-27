<?php

namespace App\Http\Controllers\Customer;

use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
        $customer = Customer::query()->where('email', $request->email)->first();
        if ($customer && Hash::check($request->password, $customer->password)) {
            session()->put('customer_id', $customer->id);
            session()->put('customer_name', $customer->name);
            session()->put('customer_email', $customer->email);
            session()->put('customer_address', $customer->address);
            session()->put('customer_phone_number', $customer->phone_number);
            return redirect($request->url ?? URL::route('customers.index'));
        }else{
            return redirect()->route('auth-customer.login')
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
}
