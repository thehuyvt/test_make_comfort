<?php

namespace App\Http\Controllers\Customer;

use App\Enums\ProductStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->get();
        $products = Product::query()
            ->where('status', '!=', ProductStatusEnum::DRAFT)
            ->limit(16)->get();
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

    //Chi tiet san pham
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


    //Trang danh sach san pham
    public function allProducts(Request $request)
    {
        $listProducts = Product::query()
            ->with([
                'category',
            ])
            ->where('status', '!=', ProductStatusEnum::DRAFT)
            ->when($request->category, function ($q,$value){
                if ($value !== '*'){
                    $q->where('category_id', $value);
                }
            })
            ->when($request->price, function ($q,$value){
                $prices = explode('-',$value);
                foreach ($prices as $key => $price){
                    $prices[$key] = (int)$price;
                }
                $q->whereBetween('sale_price', $prices);
            })
            ->when($request->key, function ($q,$value){
                $q->where(function($q) use ($value){
                    $q->orWhere('name', 'like', '%'.$value.'%');
                    $q->orWhere('slug', 'like', '%'.$value.'%');
                    $q->orWhere('id', 'like', '%'.$value.'%');
                });
            })
            ->when($request->sort, function ($q,$value){
                $q->orderBy('price', $value);
            })
            ->orderByDesc('id')
            ->paginate(12);
        foreach ($listProducts as $product){
            $product->price = $product->sale_price;
            $product->sale_price = number_format($product->sale_price);
            $product->old_price = number_format($product->old_price);
        }
        $listProducts->appends($request->all()); //add params to request
        $categories = Category::query()->get();

        return view('customer.product.index',[
            'listProducts' => $listProducts,
            'categories'=> $categories,
        ]);
//        return view('customer.product.all-product');
    }

    //Data san pham do vao trang sam pham
    public function listProducts(Request $request)
    {

        $listProducts = Product::query()
            ->with([
                'category',
            ])
            ->where('status', '!=', ProductStatusEnum::DRAFT)
            ->when($request->category, function ($q,$value){
                if ($value !== '*'){
                    $q->where('category_id', $value);
                }
            })
            ->when($request->price, function ($q,$value){
                $prices = explode('-',$value);
                foreach ($prices as $key => $price){
                    $prices[$key] = (int)$price;
                }
                $q->whereBetween('sale_price', $prices);
            })
            ->when($request->key, function ($q,$value){
                $q->where(function($q) use ($value){
                    $q->orWhere('name', 'like', '%'.$value.'%');
                    $q->orWhere('slug', 'like', '%'.$value.'%');
                    $q->orWhere('id', 'like', '%'.$value.'%');
                });
            })
            ->when($request->sort, function ($q,$value){
                $q->orderBy('price', $value);
            })
            ->orderByDesc('id')
            ->paginate(12);
        foreach ($listProducts as $product){
            $product->price = $product->sale_price;
            $product->sale_price = number_format($product->sale_price);
            $product->old_price = number_format($product->old_price);
        }
        $listProducts->appends($request->all()); //add params to request
        return response()->json(['listProducts' => $listProducts]);
    }
}
