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
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->get();
        $listStatus = ProductStatusEnum::getArrayStatus();
//        dd($listStatus);
        return view('product.create',[
            'categories'=>$categories,
            'listStatus'=>$listStatus,
        ]);
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

//        $arr = $request->validated();

        $this->model::query()->create($request->validated());
        $product = $this->model::query()->where('slug', $request->slug)->first();
        $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/thumb', $request->file('thumb'));
        $product->update([
            'thumb' => $path,
        ]);
        //product_images
        $listImages = $request->images;
        foreach ($listImages as $image){
            $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/images', $image);
            $product->images()->create([
                'path' => $path,
            ]);
        }

        //product_variants
        $listVariants = [];
        $length =  count($request->keys);
        for ($i = 0; $i < $length; $i++){
            if (!empty($request->keys[$i])){
                $listVariants[$i]['key'] = $request->keys[$i];
                if ($request->quantities[$i] === null){
                    $listVariants[$i]['quantity'] = 0;
                }else{
                    $listVariants[$i]['quantity'] = $request->quantities[$i];
                }
            }
        }
        $product->variants()->createMany($listVariants);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($productId)
    {
        $product = $this->model::query()->find($productId);
        $categories = Category::query()->get();
        $listStatus = ProductStatusEnum::getArrayStatus();
        return view('product.edit', [
            'product' => $product,
            'categories'=>$categories,
            'listStatus'=>$listStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $productId)
    {
        $product = $this->model::query()->find($productId);
        $product->update($request->validated());
        //Update product_thumb
        if (!empty($request->thumb)){
            Storage::deleteDirectory('public/uploads/'.$product->id.'/thumb');
            $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/thumb', $request->thumb);
            $product->update([
                'thumb' => $path,
            ]);
        }

        //product_images
        if (!empty($request->images)){
            $listImages = $request->images;
            $product->images()->delete();
            Storage::deleteDirectory('public/uploads/'.$product->id.'/images');
            foreach ($listImages as $image){
                $path = Storage::disk('public')->putFile('uploads/'.$product->id.'/images', $image);
                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }

        //Update variants
        $product->variants()->delete();
        $listVariants = [];
        $length =  count($request->keys);
        for ($i = 0; $i < $length; $i++){
            if (!empty($request->keys[$i])){
                $listVariants[$i]['key'] = $request->keys[$i];
                if ($request->quantities[$i] === null){
                    $listVariants[$i]['quantity'] = 0;
                }else{
                    $listVariants[$i]['quantity'] = $request->quantities[$i];
                }
            }
        }
        $product->variants()->createMany($listVariants);

        return redirect()->route('products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
