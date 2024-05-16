<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Product;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->paginate(3);
        $products = Product::query()->limit(16)->get();
        foreach ($products as $product){
            $product->sale_price = number_format($product->sale_price);
            $product->old_price = number_format($product->old_price);
        }
        return view('customer.index',[
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function productDetail($slug)
    {
        $product = Product::query()->where('slug', $slug)->firstOrFail();
        $product->sale_price = number_format($product->sale_price);
        $product->old_price = number_format($product->old_price);

        return view('customer.product.detail', [
            'product'=>$product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
