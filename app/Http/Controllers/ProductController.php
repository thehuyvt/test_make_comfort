<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $model;
    public function __construct()
    {
        $this->model = new Product();

        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

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
                });
            })
            ->paginate(1);

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

    public function api(){
        return DataTables::of($this->model->with('category'))
            ->addColumn('category_name', function ($object){
                return $object->category->name;
            })
            ->addColumn('product', function ($object){
                $arr = [];
                $arr['id'] = $object->id;
                $arr['image'] = $object->thumb;
                $arr['name'] = $object->name;
                return $arr;
            })
            ->addColumn('action', function ($object) {
                $arr = [];
                $arr['edit'] = route('products.edit', $object);
                $arr['show'] = route('products.show', $object);
                return $arr;
            })
            ->editColumn('status', function ($object){
                return ProductStatusEnum::getNameStatus($object->status);
            })
            ->editColumn('created_at', function ($object){
                return $object->dateCreated;
            })
            ->make(true);
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
            $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/thumb', $request->file('thumb'));
            $product->thumb = $path;
        } else {
            $product->thumb = $request->old_thumb;
        }

        // product_images
        $listImages = array_filter_empty($request->images);
        foreach ($listImages as $image){
            $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/images', $image);
            $product->images()->create([
                'path' => $path,
            ]);
        }

        //product_variants
        $variants = $request->variants;
        foreach ($variants as $key => $quantity){
            $product->variants()->create([
                'key' => $key,
                'quantity' => $quantity,
            ]);
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
}
