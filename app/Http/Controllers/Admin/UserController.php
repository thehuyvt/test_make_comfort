<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->model = new User();

        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);
        $listStatus = UserStatusEnum::getArrayStatus();
        View::share('title', $title);
        View::share('listStatus', $listStatus);
    }
    public function index()
    {
        $users = User::query()->where('role', '!=', 1)->paginate(10);
        return view('user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->model::query()->create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'phone_number'=> $request->phone_number,
            'status'=> $request->status,
            'role' => UserRoleEnum::EMPLOYEE->value,
        ]);
        return redirect()->route('users.index')
            ->with('success','Thêm nhân viên thành công!');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($userId)
    {
        $user = $this->model::query()
            ->where('id', $userId)
            ->where('role', '!=', 1)
            ->first();

        if ($user === null){
            return redirect()->route('users.index');
        }

        return \view('user.edit', [
            'user'=>$user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, $userId)
    {
        $user = $this->model::query()
            ->where('id', $userId)
            ->where('role', '!=', 1)
            ->first();

        if ($user === null){
            return redirect()->route('users.index');
        }

        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone_number'=> $request->phone_number,
            'status'=> $request->status,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Sửa thông tin nhân viên thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function changePassword()
    {
        return view('user.change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $this->model::query()->find(session()->get('id'));
        if (!Hash::check($request->password, $user->password)){
            return back()->withErrors([
                'password' => 'Mật khẩu cũ không chính xác!'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Đổi mật khẩu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
