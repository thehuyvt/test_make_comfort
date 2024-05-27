<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $model;
    public function __construct()
    {
        $this->model = new Product();

//        $routeName = Route::currentRouteName();
//        $arr = explode('.', $routeName);
//        $arr = array_map('ucfirst', $arr);
//        $title = implode(' - ', $arr);
        $title = 'Sản phẩm';

        View::share('title', $title);
    }
    public function index(Request $request)
    {
        $listProducts = $this->model::query()
            ->with([
                'category',
            ])
            ->when($request->category, function ($q,$value){
                $q->where('category_id', $value);
            })
            ->when($request->status, function ($q,$value){
                $q->where('status', $value);
            })
            ->when($request->status, function ($q,$value){
                $q->where(function($q) use ($value){
                    $q->orWhere('name', 'like', '%'.$value.'%');
                    $q->orWhere('slug', 'like', '%'.$value.'%');
                    $q->orWhere('id', 'like', '%'.$value.'%');
                });
            })
            ->paginate(1);
        foreach ($listProducts as $product){
            $product->status = ProductStatusEnum::getNameStatus($product->status);
        }
        $listProducts = $listProducts->appends($request->all());
        $categories = Category::query()->get();
        $listStatus = ProductStatusEnum::getArrayStatus();
        return view('product.index',[
            'listProducts' => $listProducts,
            'categories'=> $categories,
            'listStatus'=> $listStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new $this->model;
        $product->status = ProductStatusEnum::DRAFT;
        $product->name = 'Draft '.time();
        $product->slug = Str::random();
        $product->save();

        return redirect()->route('products.edit', $product);
    }


    public function update(StoreProductRequest $request, Product $product)
    {
        $options = [];
        foreach($request->options_key as $index => $key){
            $options[$key] = $request->options_values[$index];
        }
        $product->options = $options;
        $product->fill($request->all());

        if($request->thumb){
            Storage::deleteDirectory('public/uploads/'.$product->id.'/thumb');
            $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/thumb', $request->file('thumb'));
            $product->thumb = $path;
        } else {
            $product->thumb = $request->old_thumb;
        }

        // product_images
        $listImages = array_filter_empty($request->images);
        if ($listImages){
            Storage::deleteDirectory('public/uploads/'.$product->id.'/images');
            $product->images()->delete();
            foreach ($listImages as $image){
                $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/images', $image);
                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }

        //product_variants
        $variants = $request->variants;
        foreach ($variants as $key => $quantity){
            $check = true;
            foreach ($product->variants as $each){
                if ($key === $each->key){
                    $each->update([
                        'quantity' => $quantity,
                    ]);
                    $check=false;
                }
            }
            if ($check){
                $product->variants()->create([
                    'key' => $key,
                    'quantity' => $quantity,
                ]);
            }
        }

        $product->save();
        return true;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::query()->get();
        $listStatus = ProductStatusEnum::getArrayStatus();

        return view('product.edit', [
            'product' => $product,
            'categories'=> $categories,
            'listStatus'=> $listStatus,
        ]);
    }

    public function searchOptions(Request $request)
    {
        $category_id = $request->category_id;
        $key = $request->key;

        $data = $this->model
            ->where('category_id', $category_id)
            ->distinct()
            ->get('options');

        $options = [];
        foreach($data as $each){
            foreach($each->options as $index => $val){
                if(str_contains($index, $key)){
                    $options[] = $index;
                }
            }
        }

        return $options;
    }
}
