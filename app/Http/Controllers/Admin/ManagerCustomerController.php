<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ManagerCustomerController extends Controller
{
    public function __construct()
    {
        $title = "Khách hàng";
        View::share('title', $title);
    }

    public function index(Request $request)
    {
        $customers = Customer::query()
        ->withCount(['orders as total_orders' => function ($query) {
            $query->where('status', '!=' , OrderStatusEnum::DRAFT);
        }])
        ->withSum(['orders as total_amount_bought' => function ($query) {
            $query->where('status', '!=' , OrderStatusEnum::DRAFT);
        }], 'total')
        ->when($request->has('status') && $request->status !== 'all', function ($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->when($request->key, function ($q, $value){
            $q->where(function($q) use ($value){
                $q->orWhere('name', 'like', '%'.$value.'%');
                $q->orWhere('email', 'like', '%'.$value.'%');
                $q->orWhere('id', 'like', '%'.$value.'%');
                $q->orWhere('phone_number', 'like', '%'.$value.'%');
            });
        })
        ->paginate(10);
        $customers = $customers->appends($request->all());
        $listStatus = UserStatusEnum::getArrayStatus();
        return view('manager_customer.index', [
            'customers' => $customers,
            'listStatus' => $listStatus
        ]);
    }

    public function show($customerId)
    {
        $customer = Customer::query()
        ->with(['orders' => function ($query) {
            $query->where('status', '!=' , [OrderStatusEnum::DRAFT, OrderStatusEnum::ORDERING]);
        }])
        ->withCount(['orders as total_orders' => function ($query) {
            $query->where('status', '!=' , OrderStatusEnum::DRAFT);
        }])
        ->withCount(['orders as total_completed_orders' => function ($query) {
            $query->where('status', OrderStatusEnum::PROCESSED);
        }])
        ->withCount(['orders as total_cancelled_orders' => function ($query) {
            $query->where('status', OrderStatusEnum::CANCELLED);
        }])
        ->withSum(['orders as total_amount_bought' => function ($query) {
            $query->where('status', '!=' , OrderStatusEnum::DRAFT);
        }], 'total')
        ->where('id', $customerId)
        ->first();
        foreach ($customer->orders as $order){
            $order->statusName = OrderStatusEnum::getNameStatus($order->status);
        }
        if ($customer === null){
            return redirect()->route('customers.index')->with('notify', 'Khách hàng không tồn tại!');
        }
        return view('manager_customer.detail', [
            'customer' => $customer
        ]);
    }

    public function edit($customerId)
    {
        $customer = Customer::query()->find($customerId);
        if ($customer === null){
            return redirect()->route('management-customers.index')->with('notify', 'Khách hàng không tồn tại!');
        }
        $listStatus = UserStatusEnum::getArrayStatus();
        return view('manager_customer.edit', [
            'customer' => $customer,
            'listStatus' => $listStatus,
        ]);
    }

    public function update(UpdateCustomerRequest $request, $customerId)
    {
        $customer = Customer::query()->find($customerId);
        if ($customer === null){
            return redirect()->route('management-customers.index')->with('notify', 'Khách hàng không tồn tại!');
        }
        $customer->update($request->all());
        return redirect()->route('management-customers.index')->with('notify', 'Cập nhật thành công!');
    }
}
