<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\URL;

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
        if ($product->sale_price < $product->old_price) {
            $product->sale_off = round(($product->old_price - $product->sale_price) / $product->old_price * 100);
        }else{
            $product->sale_off = null;
        }
        $product->sale_price = number_format($product->sale_price);
        $product->old_price = number_format($product->old_price);

        $relatedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=',$product->id)
            ->limit(16)->get();

        foreach ($relatedProducts as $each){
            $each->sale_price = number_format($each->sale_price);
            $each->old_price = number_format($each->old_price);
        }
        return view('customer.product.detail', [
            'product'=>$product,
            'relatedProducts' => $relatedProducts,
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
}
